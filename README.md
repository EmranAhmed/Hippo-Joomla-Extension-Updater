# Hippo Joomla Extension Updater
Commercial Joomla Extension Updater to Update Joomla Extensions By Given Template Parameters.

# How to use it

There is two part to use Hippo Joomla Extension Updater to work properly.

## Development Part

- Just Download and Extract it.
- I use [T3v3 Framework](http://www.t3-framework.org/ "T3 for Joomla") thats why I use it in my plugin. You should change and edit or add your template compatible codes. Make sure that you put all your params in `$extra_query` varible on file `hippoupdater.php` [file](https://github.com/EmranAhmed/Hippo-Joomla-Extension-Updater/blob/master/plg_system_hippoupdater/hippoupdater.php#L49).

```php
if (defined('T3_PLUGIN') && T3::detect() && $option == 'com_templates.style' && !empty($data->id)) {

                $params = new JRegistry;
                $params->loadString($data->params);

                // Getting Param envato_purchase_code
                $key = $params->get('envato_purchase_code');

                // Getting Param envato_username
                $username = $params->get('envato_username');

                // Getting Template Name to sure which Template requests for an update :)
                $template = trim($data->template); 

                $extra_query = '';

                if(!empty($key) and !empty($username) )
                {

                    // Important: you are supposed to use &amp; instead of a straight ampersand
                    $extra_query = 'purchase_code=' . urlencode($key);
                    $extra_query .='&amp;username=' . urlencode($username);
                    $extra_query .='&amp;template=' . urlencode($template);

```
- Make `.zip` file of `plg_system_hippoupdater` directory, now install it from joomla extension manager :smile:
- Add template parameters on `templateDetails.xml` for username / purchasecode / other data you need from user. [Understanding Joomla! templates](https://docs.joomla.org/Understanding_Joomla!_templates#Parameters "Understanding Joomla! templates")
- Add your update server on your template you can see my example in this repo or take more knowledge from [Adding an update server](https://docs.joomla.org/J2.5:Developing_a_MVC_Component/Adding_an_update_server "Adding an update server")
- You can use collection server or extension server as you need :smile:
- In `downloadurl` of [template_name.xml](https://github.com/EmranAhmed/Hippo-Joomla-Extension-Updater/blob/master/joomla-update/template_name.xml#L13) I use `download.php` file to serve our updated extensions.

# Your Server Part

- Put `download.php` file on your server secure location or others. Here I use envato purchase code verifier to verify my envato valid author who bought my Joomla Template :grinning: 
- You can see `joomla-update` directory in this repo.
- There is `zips` directory you can put your latest updated template copy or any where else. Just you should change some code on `download.php` file.

## Request
- Please donot remove my Credit line from this plugin. :blush:

