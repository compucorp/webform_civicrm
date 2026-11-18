<?php

/**
 * @file
 * Hooks provided by the Webform CiviCRM module.
 */

/**
 * Alter the memberships a webform submission may renew.
 *
 * Invoked in wf_crm_webform_postprocess::processMemberships() before the
 * webform picks an existing membership of the same organisation to renew.
 * Remove an item to stop it being renewed; if nothing suitable is left, a new
 * membership is created instead. Adds no rules itself: with no implementations
 * behaviour is unchanged. Does not affect the membership message shown when
 * the form loads (wf_crm_webform_preprocess::loadMemberships()).
 *
 * @param array $memberships
 *   Membership.get rows for the contact, as built by
 *   wf_crm_webform_base::findMemberships(): enabled membership types only, no
 *   inherited memberships, current ones first. Each row also has 'is_active'
 *   (the status's is_current_member flag) and 'status' (the status label).
 * @param int $cid
 *   The CiviCRM contact ID the membership is for.
 * @param object $node
 *   The webform node being submitted.
 */
function hook_webform_civicrm_renewable_memberships_alter(array &$memberships, $cid, $node) {
  // Example: never renew a membership that ended before 2020.
  foreach ($memberships as $key => $membership) {
    if (!empty($membership['end_date']) && $membership['end_date'] < '2020-01-01') {
      unset($memberships[$key]);
    }
  }
}
