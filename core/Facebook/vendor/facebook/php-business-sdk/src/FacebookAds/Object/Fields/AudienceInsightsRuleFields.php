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

class AudienceInsightsRuleFields extends AbstractEnum {

  const ARCHIVED = 'archived';
  const CAN_BE_UPDATED = 'can_be_updated';
  const CREATED_BY = 'created_by';
  const CREATION_TIME = 'creation_time';
  const DESCRIPTION = 'description';
  const ID = 'id';
  const LANGUAGE = 'language';
  const NAME = 'name';
  const RULE_COMPONENTS = 'rule_components';
  const STUDIES = 'studies';

  public function getFieldTypes() {
    return array(
      'archived' => 'bool',
      'can_be_updated' => 'bool',
      'created_by' => 'User',
      'creation_time' => 'datetime',
      'description' => 'string',
      'id' => 'string',
      'language' => 'string',
      'name' => 'string',
      'rule_components' => 'list<Object>',
      'studies' => 'list<Object>',
    );
  }
}
