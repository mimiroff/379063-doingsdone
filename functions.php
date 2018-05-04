<?php
function renderTemplate ($template_path, $data) {
if(is_file($template_path)) {
foreach($data as $key => $value) {
${$key} = $value;
}
ob_start();
require_once($template_path);
return ob_get_clean();
} else {
return '';
}
};
?>

