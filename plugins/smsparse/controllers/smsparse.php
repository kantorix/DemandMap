<?php
class Hello_Controller extends Controller 
{
    public function parse($sms)
    {
		$fp = fopen("/Users/CHR1S/Sites/Ushahidi_Web-2.7.1/plugins/smsparse/myText123.txt","w");
		fwrite($fp,$sms->message);
		fclose($fp);     
    }
}
?>