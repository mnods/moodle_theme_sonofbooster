<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * sonofbooster theme.
 *
 * @package    theme_sonofbooster
 * @copyright  &copy; 2019-onwards G J Barnard.
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    // Add your settings here.
    
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/sonofbooster/classes/admin_setting_configfontsizes.php")) {
        require_once($CFG->dirroot . '/theme/sonofbooster/classes/admin_setting_configfontsizes.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/sonofbooster/classes/admin_setting_configfontsizes.php")) {
        require_once($CFG->themedir . '/sonofbooster/classes/admin_setting_configfontsizes.php');
    }
     // Font sizes.
    $name = 'theme_sonofbooster/fontsizes';
    $title = get_string('fontsizes', 'theme_sonofbooster');
    $base = '1rem';
    $h1 = '2.5';
    $h2 = '2';
    $h3 = '1.75';
    $h4 = '1.5';
    $h5 = '1.25';
    $h6 = '1';
    $default = $base.PHP_EOL.$h1.PHP_EOL.$h2.PHP_EOL.$h3.PHP_EOL.$h4.PHP_EOL.$h5.PHP_EOL.$h6;
    $description = get_string('fontsizesdesc', 'theme_sonofbooster',
        array('base' => $base, 'h1' => $h1, 'h2' => $h2, 'h3' => $h3, 'h4' => $h4, 'h5' => $h5, 'h6' => $h6));
    $setting = new admin_setting_configfontsizes($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
      
    // Custom CSS.
    $name = 'theme_sonofbooster/customcss';
    $title = get_string('customcss', 'theme_sonofbooster');
    $description = get_string('customcssdesc', 'theme_sonofbooster');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);


 if (file_exists("{$CFG->dirroot}/theme/sonofbooster/classes/admin_setting_blockwidth.php")) {
        require_once($CFG->dirroot . '/theme/sonofbooster/classes/admin_setting_blockwidth.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/sonofbooster/classes/admin_setting_blockwidth.php")) {
        require_once($CFG->themedir . '/sonofbooster/classes/admin_setting_blockwidth.php');
    }
// Block and Content widths from fordson - offset by 30px
// https://github.com/dbnschools/moodle-theme_fordson/blob/master/settings/presets_adjustments_settings.php
// see scss/mdl/_blocks.scss and lib.php theme_sonofbooster_get_pre_scss
    $name = 'theme_sonofbooster/blockwidth';
    $title = get_string('blockwidth', 'theme_sonofbooster');
    $description = get_string('blockwidth_desc', 'theme_sonofbooster');
    $defaultsetting = '280px';
    $choices = array(
            '280px' => '250px',
            '305px' => '275px',
            '330px' => '300px',
            '355px' => '325px',
            '380px' => '350px',
            '405px' => '375px',
            '430px' => '400px',
            '455px' => '425px',
            '480px' => '450px',
        );
    //$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting = new admin_setting_blockwidth($name, $visiblename, $description, $defaultsetting, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Drawer width - see scss/mdl/_drawer.scss and lib.php theme_sonofbooster_get_pre_scss
    // adapted from https://github.com/dbnschools/moodle-theme_fordson/blob/master/settings/presets_adjustments_settings.php
    $name = 'theme_sonofbooster/drawerwidth';
    $title = get_string('drawerwidth', 'theme_sonofbooster');
    $description = get_string('drawerwidth_desc', 'theme_sonofbooster');
    $default = '285px';
    $choices = array(
            '240px' => '240px',
            '255px' => '255px',
            '270px' => '270px',
            '285px' => '285px',
            '300px' => '300px',
            '315px' => '315px',
            '330px' => '330px',
            '345px' => '345px',
            '360px' => '360px',
            '375px' => '375px',
            '390px' => '390px',
            '405px' => '405px',
        );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

}
