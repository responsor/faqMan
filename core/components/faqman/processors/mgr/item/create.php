<?php
/**
 * faqMan
 *
 * Copyright 2010 by Josh Tambunga <josh+faqman@joshsmind.com>
 *
 * faqMan is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * faqMan is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * faqMan; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package faqman
 */
/**
 * Create an Item
 *
 * @package faqman
 * @subpackage processors
 */

// Make sure we are submitting something to create
if (empty($_POST['set'])) return $modx->error->failure($modx->lexicon('faqman.set_err_ns'));

// Create a new faqManItem object and fill it with information
$item = $modx->newObject('faqManItem');
$item->fromArray($_POST);

// New faqManItems are added at the end of the list
$total = $modx->getCount('faqManItem', array('set' => $_POST['set']));
$item->set('rank',$total);

// Check if set is currently mark as unpublished
$set = $modx->getObject('faqManSet', $_POST['set']);
if ($set->get('published') == false) {
    $item->published = false;
}

// Try to save and return our status
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('faqman.item_err_save'));
}
return $modx->error->success('', $item);
