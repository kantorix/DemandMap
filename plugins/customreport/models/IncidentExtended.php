<?php

class IncidentExtended_Model extends Incident_Model {

  /**
   * Gets the reports that match the conditions specified in the $where parameter
   * The conditions must relate to columns in the incident, location, incident_category
   * category and media tables
   *
   * @param array $where List of conditions to apply to the query
   * @param mixed $limit No. of records to fetch or an instance of Pagination
   * @param string $order_field Column by which to order the records
   * @param string $sort How to order the records - only ASC or DESC are allowed
   * @return Database_Result
   */
  public static function get_incidents($where = array(), $limit = NULL, $order_field = NULL, $sort = NULL, $count = FALSE) {
    // Get the table prefix
    $table_prefix = Kohana::config('database.default.table_prefix');

    // To store radius parameters
    $radius = array();
    $having_clause = "";
    if (array_key_exists('radius', $where)) {
      // Grab the radius parameter
      $radius = $where['radius'];

      // Delete radius parameter from the list of predicates
      unset ($where['radius']);
    }

    // Query
    // Normal query
    if (!$count) {
      $sql = 'SELECT DISTINCT i.id incident_id, i.incident_title, i.incident_description, i.incident_date, i.incident_mode, i.incident_active, '
        . 'i.incident_verified, i.location_id, l.country_id, l.location_name, l.latitude, l.longitude, p.person_phone ';
    }
    // Count query
    else {
      $sql = 'SELECT COUNT(DISTINCT i.id) as report_count ';
    }

    // Check if all the parameters exist
    if (count($radius) > 0 AND array_key_exists('latitude', $radius) AND array_key_exists('longitude', $radius)
      AND array_key_exists('distance', $radius)
    ) {
      // Calculate the distance of each point from the starting point
      $sql .= ", ((ACOS(SIN(%s * PI() / 180) * SIN(l.`latitude` * PI() / 180) + COS(%s * PI() / 180) * "
        . "	COS(l.`latitude` * PI() / 180) * COS((%s - l.`longitude`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance ";

      $sql = sprintf($sql, $radius['latitude'], $radius['latitude'], $radius['longitude']);

      // Set the "HAVING" clause
      $having_clause = "HAVING distance <= " . intval($radius['distance']) . " ";
    }

    $sql .= 'FROM ' . $table_prefix . 'incident i '
      . 'LEFT JOIN ' . $table_prefix . 'location l ON (i.location_id = l.id) '
      . 'LEFT JOIN ' . $table_prefix . 'incident_category ic ON (ic.incident_id = i.id) '
      . 'LEFT JOIN ' . $table_prefix . 'category c ON (ic.category_id = c.id) '
      . 'LEFT JOIN ' . $table_prefix . 'incident_person p ON (i.id = p.incident_id) ';

    // Check if the all reports flag has been specified
    if (array_key_exists('all_reports', $where) AND $where['all_reports'] == TRUE) {
      unset ($where['all_reports']);
      $sql .= 'WHERE 1=1 ';
    }
    else {
      $sql .= 'WHERE i.incident_active = 1 ';
    }

    // Check for the additional conditions for the query
    if (!empty($where) AND count($where) > 0) {
      foreach ($where as $predicate) {
        $sql .= 'AND ' . $predicate . ' ';
      }
    }

    // Might need "GROUP BY i.id" do avoid dupes

    // Add the having clause
    $sql .= $having_clause;

    // Check for the order field and sort parameters
    if (!empty($order_field) AND !empty($sort) AND (strtoupper($sort) == 'ASC' OR strtoupper($sort) == 'DESC')) {
      $sql .= 'ORDER BY ' . $order_field . ' ' . $sort . ' ';
    }
    else {
      $sql .= 'ORDER BY i.incident_date DESC ';
    }

    // Check if the record limit has been specified
    if (!empty($limit) AND is_int($limit) AND intval($limit) > 0) {
      $sql .= 'LIMIT 0, ' . $limit;
    }
    elseif (!empty($limit) AND $limit instanceof Pagination_Core) {
      $sql .= 'LIMIT ' . $limit->sql_offset . ', ' . $limit->items_per_page;
    }

    // Event to alter SQL
    Event::run('ushahidi_filter.get_incidents_sql', $sql);

    // Kohana::log('debug', $sql);
    return Database::instance()->query($sql);
  }

}