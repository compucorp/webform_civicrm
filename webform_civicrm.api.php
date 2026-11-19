<?php

/**
 * @file
 * Hooks provided by the Webform CiviCRM module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter the memberships a webform submission may renew.
 *
 * Invoked in wf_crm_webform_postprocess::processMemberships() before the
 * webform picks an existing membership of the same organisation to renew.
 * Remove an item to stop it being renewed; if nothing suitable is left, a new
 * membership is created instead (when the form's membership has 'Number of
 * terms' set; otherwise the list isn't used and a new membership is always
 * created). Adds no rules itself: with no implementations behaviour is
 * unchanged. Does not affect the membership message shown when the form loads
 * (wf_crm_webform_preprocess::loadMemberships()).
 *
 * @param array $memberships
 *   Membership.get rows for the contact, as built by
 *   wf_crm_webform_base::findMemberships(): enabled membership types only, no
 *   inherited memberships, current ones first. The keys are list positions
 *   (0-based), not membership IDs. Remove items by key with unset(); don't add
 *   or reorder items, because order matters (without an exact type match the
 *   last same-organisation match wins). Each row also has 'is_active' (the
 *   status's is_current_member flag), 'status' (the status label) and
 *   'fee_amount_from_membership'.
 * @param int $cid
 *   The CiviCRM contact ID the membership is for.
 * @param object $node
 *   The webform node being submitted. Treat as read-only.
 */
function hook_webform_civicrm_renewable_memberships_alter(array &$memberships, $cid, $node) {
  // Example: never renew a membership that ended before 2020.
  foreach ($memberships as $key => $membership) {
    if (!empty($membership['end_date']) && $membership['end_date'] < '2020-01-01') {
      unset($memberships[$key]);
    }
  }
}

/**
 * @} End of "addtogroup hooks".
 */
