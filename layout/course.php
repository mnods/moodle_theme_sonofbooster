<?php
defined('MOODLE_INTERNAL') || die();

// Detect server date time AJAX call.
$sdt = \optional_param('sdt', false, PARAM_BOOL);
if ($sdt) {
    \require_sesskey();

    header('HTTP/1.1 200 OK');
    header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
    header('Content-Type: text/plain; charset=utf-8');
    echo strftime('%d/%m/%Y %H:%M:%S');

    die();
}

user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
require_once($CFG->libdir . '/behat/lib.php');

if (isloggedin()) {
    $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
} else {
    $navdraweropen = false;
}
$extraclasses = [];
if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$serverdatetime = strftime('%d/%m/%Y %H:%M:%S');
$courseurl = new \moodle_url('/course/view.php');
$courseurl->param('id', $PAGE->course->id);
$courseurl->param('sdt', true);
$courseurl->param('sesskey', sesskey());
$PAGE->requires->js_call_amd('theme_sonofbooster/serverdatetime', 'init', array('data' => array('courseurl' => $courseurl->out(false))));
$this->page->requires->js_call_amd('theme_sonofbooster/countdowntimer', 'initialise', $params);
$this->page->requires->js_call_amd('theme_sonofbooster/showinput', 'init');
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'navdraweropen' => $navdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'serverdatetime' => $serverdatetime
];

$templatecontext['flatnavigation'] = $PAGE->flatnav;
echo $OUTPUT->render_from_template('theme_sonofbooster/course', $templatecontext);
//echo $OUTPUT->main_content();
