<?php
/**
 * Copyright (c) 2015-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

namespace FacebookAds\Object\Fields;

use FacebookAds\Enum\AbstractEnum;

/**
 * This class is auto-generated.
 *
 * For any issues or feature requests related to this class, please let us know
 * on github and we'll fix in our codegen framework. We'll not be able to accept
 * pull request for this class.
 *
 */

class CustomAudienceSharedAccountCampaignInfoFields extends AbstractEnum {

  const ACCOUNT_ID = 'account_id';
  const ACCOUNT_NAME = 'account_name';
  const ADSET_EXCLUDING_COUNT = 'adset_excluding_count';
  const ADSET_INCLUDING_COUNT = 'adset_including_count';
  const CAMPAIGN_DELIVERY_STATUS = 'campaign_delivery_status';
  const CAMPAIGN_OBJECTIVE = 'campaign_objective';
  const CAMPAIGN_PAGES = 'campaign_pages';
  const CAMPAIGN_SCHEDULE = 'campaign_schedule';
  const ID = 'id';

  public function getFieldTypes() {
    return array(
      'account_id' => 'string',
      'account_name' => 'string',
      'adset_excluding_count' => 'unsigned int',
      'adset_including_count' => 'unsigned int',
      'campaign_delivery_status' => 'string',
      'campaign_objective' => 'string',
      'campaign_pages' => 'list<Object>',
      'campaign_schedule' => 'string',
      'id' => 'string',
    );
  }
}
