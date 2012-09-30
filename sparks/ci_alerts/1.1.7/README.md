CI (CodeIgniter) Alerts
============================

I was looking at using flashdata for alerts, but it didn't seem to fit the bill. What if I want to add multiple alerts and have them displayed when I go to the next page? What if I want to set the type of alert (success, error, etc.) so I can style it appropriately? What if I want to display two success alerts and one warning alert? I don't want to have a ton of code in each view like this, which will limit me to one alert of each type anyway:

    <?php if ($this->session->flashdata('success') !== FALSE): ?>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div><!--alert-->
    <?php endif;
    if ($this->session->flashdata('error') !== FALSE): ?>
    <div class="alert alert-error"><?=$this->session->flashdata('error')?></div><!--alert-->
    <?php endif; ?>
    // etc...

CI Alerts aims to solve this problem. It allows you to add alerts of type success, error, info, or warning to flashdata and later display them. It adds the alerts to arrays for each one, so the success flashdata is an array with each success alert in it. You can display all alerts of a certain type or all alerts. The wrapping HTML is set in the config file and has separate html for each type. Since it's flashdata it only lasts one page reload by default, so keep that in mind.

Setup
----------------------------

1. Install Sparks at [GetSparks.org](http://getsparks.org)
3. Edit **config/ci_alerts.php** with whatever html you want to use to display alerts. Defaults to [Twitter Bootstrap](http://bootstrap.io) alerts.

Usage
----------------------------

Load Spark 

    ```$this->load->spark('ci_alerts/1.1.7')```

Set Success, Set Error, Set Info, Set Warning

    $this->ci_alerts->set($type, $message);
    
Display Alerts

    $this->ci_alerts->display($optional_type);

HTML wrappers are configurable in **config/ci_alerts.php**. There are also methods for retrieving alerts in arrays for flexibility. Have fun!


----------------------------

Changelog
----------------------------

**1.1.7**

* [donnykuria](https://github.com/donnykurnia) fixed bug which prevented multiple successive sets of the same type of alert before displaying.

**1.1.6**

* Added config value on whether to remove duplicate alerts
* Added removing of duplicate alerts in ```set()``` method
* Autoload ```config/ci_alerts.php```
* Added data-dismiss to alert X links in ```config/ci_alerts.php``` to allow closing

**1.1.5**

* Fixed bug with serialization of alert categories. Removed all serialization and unserialization as this is handled by CodeIgniter.
* Removed default alert type. It was impossible to fall back on anyway because it is the first param and the second param is required.