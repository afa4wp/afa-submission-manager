## Form Slug

Before attempting to add a new form builder to the plugin, it's essential to define the form slug. The form slug acts as a unique identifier for your form, enabling the plugin to recognize and process it accurately. These slugs are added inside the `Constant.php` file located at `/includes/plugins/Constant.php` and are used to create corresponding folders with the same names in the routes, controllers, and models directories, ensuring a well-structured organization.

For example:
```
const FORM_SLUG_CF7 = 'cf7'; // Contact Form 7 
const FORM_SLUG_GF  = 'gf';  // Gravity Form 
const FORM_SLUG_WEF = 'wef'; // WeForm
const FORM_SLUG_WPF = 'wpf'; // WPForms
const FORM_SLUG_EFB = 'efb'; // ELementor Form Builder
```
## Register Form Slug

By establishing these slugs within the `Constant.php` file, you'll maintain an organized codebase and ensure that your form builder integrates seamlessly with the plugin.

When defining slugs, it's crucial to keep them simple and reflective of the specific form builder you intend to add. A well-chosen slug not only enhances clarity but also aids in identifying the associated form builder at a glance. Consider using intuitive and abbreviated names that encapsulate the essence of the form builder. For exemple we use `cf7` to represent `Contact Form 7`. By following this practice, you'll maintain a consistent and easily understandable naming convention for your form builders, promoting a more organized and developer-friendly codebase.

Once you've defined the slug for your new form builder, the next step is to register it within the `get_default_values`  function inside `/includes/database/SupportedPlugins.php`, it mean add new array inside `get_default_values`. This function is responsible for providing information about the supported plugins and their details. Here's how you can register your new form builder:
```
array(
    'slug'        => 'nfp', // Replace 'nfp' with the desired slug
    'name'        => 'New Form Plugin', // Replace 'New Form Plugin' with the plugin name
    'plugin_path' => 'new-form-plugin/new-form-plugin.php', // Replace with the actual plugin path
)
```

1. **'slug'**: Replace **'nfp'** with your desired slug. This is the unique identifier for your form builder within the plugin.
2. **'name'**: Replace **'New Form Plugin'** with the name of your specific form builder. This name is displayed within the plugin to help users identify and select it.
3. **'plugin_path'**: Replace **'new-form-plugin/new-form-plugin.php'** with the actual path to your form builder's main plugin file. This ensures that the plugin can locate and activate your form builder correctly.

By following these steps and defining a new slug, you'll seamlessly integrate your form builder with the plugin's ecosystem, making it accessible to users and maintaining an organized codebase.

```
public function get_default_values() {

    $values = array(
        // Your existing supported plugins
        array(
            'slug'        => 'cf7',
            'name'        => 'Contact Form 7',
            'plugin_path' => 'contact-form-7/wp-contact-form-7.php',
        ),
        array(
            'slug'        => 'gf',
            'name'        => 'Gravity Forms',
            'plugin_path' => 'gravityforms/gravityforms.php',
        ),
        array(
            'slug'        => 'wef',
            'name'        => 'weForms',
            'plugin_path' => 'weforms/weforms.php',
        ),
        array(
            'slug'        => 'wpf',
            'name'        => 'WPForms',
            'plugin_path' => 'wpforms/wpforms.php',
        ),
        array(
            'slug'        => 'efb',
            'name'        => 'Elementor Form Builder',
            'plugin_path' => 'elementor-pro/elementor-pro.php',
        ),
        // Add your new form builder with the desired slug, name, and plugin path
        array(
            'slug'        => 'nfp', // Replace 'nfp' with the desired slug
            'name'        => 'New Form Plugin', // Replace 'New Form Plugin' with the plugin name
            'plugin_path' => 'new-form-plugin/new-form-plugin.php', // Replace with the actual plugin path
        ),
    );

    return $values;
}

```
