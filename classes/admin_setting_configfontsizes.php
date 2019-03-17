class admin_setting_configfontsizes extends admin_setting_configtext {
    public function __construct($name, $visiblename, $description, $defaultsetting) {
            parent::__construct($name, $visiblename, $description, $defaultsetting, PARAM_TEXT);
        }
 public function output_html($data, $query='') {
        global $OUTPUT;
        $values = $this->encode_for_form($data);
        $default = $this->get_defaultsetting();
        $context = (object) [
            'size' => $this->size,
            'id' => $this->get_id(),
            'name' => $this->get_full_name(),
            'value' => $values,
            'rows' => 6,
            'cols' => 7,
            'forceltr' => $this->get_force_ltr(),
        ];
        $element = $OUTPUT->render_from_template('theme_sonofbooster/setting_configfontsizes', $context);

        $warning = '';

        return format_admin_setting($this, $this->visiblename, $element, $this->description, true, $warning, $default, $query);
    }

public function validate($data) {
        $validated = parent::validate($data); // First validate the data from a text and numbers only point of view.

        if ($validated === true) {
            $data = self::decode_from_db($data);
            // Ensure there are enough settings.
            if (count($data) != 7) {
                $validated = get_string('fontsizessizeerror', 'theme_moobytes');
            } else {
                // Ensure that heading multipliers decrease.
                $index = 2;
                while (($index < 7) or ($validated != true)) {
                    $previous = $data[($index -1)];
                    $current = $data[$index];
                    if ($current > $previous) {
                        $validated = get_string('fontsizesordererror', 'theme_sonofbooster', array('current' => $current, 'previous' => $previous));
                    }
                    $index++;
                }
            }
        }

        return $validated;
    }
   public static function decode_from_db($data) {
        return explode(',', $data);
    }

    private function encode_for_form($data) {
        return implode(PHP_EOL, self::decode_from_db($data));
    }

    private function decode_from_form($data) {
        return implode(',', explode(PHP_EOL, $data));
    }
   
    public function write_setting($data) {
        // Trim any spaces to avoid spaces at ends.
        $data = trim($data);
        if ($data === '') {
            // Override parent behaviour and set to default if empty string.
            $data = $this->get_defaultsetting();
        }
        $data = $this->decode_from_form($data);

        return parent::write_setting($data);
    }
}
