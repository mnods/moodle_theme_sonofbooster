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
 * @copyright  &copy; 2018-onwards G J Barnard.
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

class theme_sonofbooster_core_renderer extends \theme_boost\output\core_renderer {
    // Add your methods here.
    
    public function sonofboosterblocks($region, $blocksperrow = 0) {
        $output = '';
        $displayregion = $this->page->apply_theme_region_manipulations($region);
        $editing = $this->page->user_is_editing();
        if (($this->page->blocks->region_has_content($displayregion, $this)) || ($editing)) {
            $attributes = array(
                'id' => 'block-region-'.$region,
                'class' => 'block-region',
                'data-blockregion' => $region,
                'data-droptarget' => '1'
            );

            $output .= html_writer::start_tag('section', array('class' => 'd-print-none'));
            $regioncontent = '';

            if ($editing) {
                if ($blocksperrow > 0) {
                    $attributes['class'] .= ' colly-container editing';
                }
                $output .= html_writer::start_tag('div', array('class' => 'row'));
                $output .= html_writer::tag('span', html_writer::tag('span', get_string('region-'.$region, 'theme_sonofbooster')),
                    array('class' => 'regionname col-12 text-center'));
                $output .= html_writer::end_tag('div');
            }
            if ($this->page->blocks->region_has_content($region, $this)) {
                if ($blocksperrow > 0) {
                    $regioncontent .= $this->sonofbooster_blocks_for_region($region, $blocksperrow, $editing);
                } else {
                    $regioncontent .= $this->blocks_for_region($region);
                }
            }
            $output .= html_writer::tag('aside', $regioncontent, $attributes);
            $output .= html_writer::end_tag('section');
        }

        return $output;
    }
    
    protected function sonofbooster_blocks_for_region($region, $blocksperrow, $editing) {
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);
        $output = '';

        $blockcount = count($blockcontents);
        if ($blockcount >= 1) {
            if (!$editing) {
                $output .= html_writer::start_tag('div', array('class' => 'colly-container'));
            }
            $lastblock = null;
            $zones = array();
            foreach ($blockcontents as $bc) {
                $zones[] = $bc->title;
            }

            // When editing we want all the blocks to be the same for ease of editing.
            if (($blocksperrow > 4) || ($editing)) {
                $blocksperrow = 4; // Will result in a 'colly-4' when more than one row.
            }
            $rows = $blockcount / $blocksperrow; // Maximum blocks per row.

            if (!$editing) {
                if ($rows <= 1) {
                    $colly = $blockcount;
                    if ($colly < 1) {
                        // Should not happen but a fail safe.  Will look intentionally odd.
                        $colly = 4;
                    }
                } else {
                    $colly = $blocksperrow;
                }
            }

            $currentblockcount = 0;
            $currentrow = 0;
            $currentrequiredrow = 1;
            foreach ($blockcontents as $bc) {

                if (!$editing) { // Fix to four columns only when editing - done in CSS.
                    $currentblockcount++;
                    if ($currentblockcount > ($currentrequiredrow * $blocksperrow)) {
                        // Tripping point.
                        $currentrequiredrow++;
                        // Break...
                        $output .= html_writer::end_tag('div');
                        $output .= html_writer::start_tag('div', array('class' => 'colly-container'));
                        // Recalculate colly if needed...
                        $remainingblocks = $blockcount - ($currentblockcount - 1);
                        if ($remainingblocks < $blocksperrow) {
                            $colly = $remainingblocks;
                            if ($colly < 1) {
                                // Should not happen but a fail safe.  Will look intentionally odd.
                                $colly = 4;
                            }
                        }
                    }

                    if ($currentrow < $currentrequiredrow) {
                        $currentrow = $currentrequiredrow;
                    }

                    $bc->attributes['class'] .= ' colly-'.$colly;
                }

                if ($bc instanceof block_contents) {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                } else if ($bc instanceof block_move_target) {
                    $output .= $this->block_move_target($bc, $zones, $lastblock, $region);
                } else {
                    throw new coding_exception('Unexpected type of thing ('.get_class($bc).') found in list of block contents.');
                }
            }
            if (!$editing) {
                $output .= html_writer::end_tag('div');
            }
        }

        return $output;
    }
    
    public function block(block_contents $bc, $region) {
        $bc = clone($bc); // Avoid messing up the object passed in.
        if (empty($bc->blockinstanceid) || !strip_tags($bc->title)) {
            $bc->collapsible = block_contents::NOT_HIDEABLE;
        }

        $id = !empty($bc->attributes['id']) ? $bc->attributes['id'] : uniqid('block-');
        $context = new stdClass();
        $context->skipid = $bc->skipid;
        $context->blockinstanceid = $bc->blockinstanceid;
        $context->dockable = $bc->dockable;
        $context->id = $id;
        $context->hidden = $bc->collapsible == block_contents::HIDDEN;
        $context->skiptitle = strip_tags($bc->title);
        $context->showskiplink = !empty($context->skiptitle);
        $context->arialabel = $bc->arialabel;
        $context->ariarole = !empty($bc->attributes['role']) ? $bc->attributes['role'] : 'complementary';
        $context->classes = trim($bc->attributes['class']);
        $context->type = $bc->attributes['data-block'];
        $context->title = $bc->title;
        $context->content = $bc->content;
        $context->annotation = $bc->annotation;
        $context->footer = $bc->footer;
        $context->hascontrols = !empty($bc->controls);
        if ($context->hascontrols) {
            $context->controls = $this->block_controls($bc->controls, $id);
        }

        return $this->render_from_template('core/block', $context);
    }
}
