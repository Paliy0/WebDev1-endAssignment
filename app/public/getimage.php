use Cloudinary\Api\Admin\AdminApi;

$admin = new AdminApi();
echo '
<pre>';
echo json_encode($admin->asset('flower_sample', [
    'colors' => TRUE]), JSON_PRETTY_PRINT
);
echo '</pre>';