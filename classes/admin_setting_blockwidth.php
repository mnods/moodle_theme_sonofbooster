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
 *
 * @package     theme_sonofbooster
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Select one value from list from moodle/lib/adminlib.php
**/

require_once($CFG->dirroot . '/lib/adminlib.php');

class admin_setting_blockwidth extends admin_setting_configselect {
    public function __construct($name, $visiblename, $description, $defaultsetting, $choices) {
            parent::__construct($name, $visiblename, $description, $defaultsetting);
        }
  
  /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return $this->config_read($this->name);
    }
    /**
     * Save a setting
     *
     * @param string $data
     * @return string empty of error string
     */
    public function write_setting($data) {
        if (!$this->load_choices() or empty($this->choices)) {
            return '';
        }
        if (!array_key_exists($data, $this->choices)) {
            return ''; // ignore it
        }
        return ($this->config_write($this->name, $data) ? '' : get_string('errorsetting', 'admin'));
    }

  
    public function output_html($data, $query='') {
        global $OUTPUT;
        $default = $this->get_defaultsetting();
        $current = $this->get_setting();
        if (!$this->load_choices() || empty($this->choices)) {
            return '';
        }
        $context = (object) [
            'id' => $this->get_id(),
            'name' => $this->get_full_name(),
        ];
        if (!is_null($default) && array_key_exists($default, $this->choices)) {
            $defaultinfo = $this->choices[$default];
        } else {
            $defaultinfo = NULL;
        }
        // Warnings.
        $warning = '';
        if ($current === null) {
            // First run.
        } else if (empty($current) && (array_key_exists('', $this->choices) || array_key_exists(0, $this->choices))) {
            // No warning.
        } else if (!array_key_exists($current, $this->choices)) {
            $warning = get_string('warningcurrentsetting', 'admin', $current);
            if (!is_null($default) && $data == $current) {
                $data = $default; // Use default instead of first value when showing the form.
            }
        }
        $options = [];
        $template = 'core_admin/setting_configselect';
        
        foreach ($this->choices as $value => $name) {
            $options[] = [
                'value' => $value,
                'name' => $name,
                'selected' => (string) $value == $data
            ];
        }
        $context->options = $options;
        $element = $OUTPUT->render_from_template($template, $context);
        return format_admin_setting($this, $this->visiblename, $element, $this->description, true, $warning, $defaultinfo, $query);
    }
    
}
