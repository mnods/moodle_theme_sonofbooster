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

    // Custom CSS.
    $name = 'theme_sonofbooster/customcss';
    $title = get_string('customcss', 'theme_sonofbooster');
    $description = get_string('customcssdesc', 'theme_sonofbooster');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

// Block and Content widths from fordson
    $name = 'theme_sonofbooster/blockwidth';
    $title = get_string('blockwidth', 'theme_sonofbooster');
    $description = get_string('blockwidth_desc', 'theme_sonofbooster');
    $default = '280px';
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
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choice);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
}
