<!-- Change the string after key= in the script below to the key that you have obtained in the google maps -->
<?php
$gmap_api_key = $this->db->get_where('settings', array('code' => 'SITE_GMAP_API_KEY'))->row()->string_value;;
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php if(isset($gmap_api_key)) echo $gmap_api_key; ?>" type="text/javascript"> </script>