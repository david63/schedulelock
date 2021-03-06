# Schedule Topic Lock extension for phpBB

An extension to schedule the locking of a topic.

[![Build Status](https://github.com/david63/schedulelock/workflows/Tests/badge.svg)](https://github.com/phpbb-extensions/david63/schedulelock)
[![License](https://poser.pugx.org/david63/schedulelock/license)](https://packagist.org/packages/david63/schedulelock)
[![Latest Stable Version](https://poser.pugx.org/david63/schedulelock/v/stable)](https://packagist.org/packages/david63/schedulelock)
[![Latest Unstable Version](https://poser.pugx.org/david63/schedulelock/v/unstable)](https://packagist.org/packages/david63/schedulelock)
[![Total Downloads](https://poser.pugx.org/david63/schedulelock/downloads)](https://packagist.org/packages/david63/schedulelock)
[![codecov](https://codecov.io/gh/david63/schedulelock/branch/master/graph/badge.svg?token=D2500PgRex)](https://codecov.io/gh/david63/schedulelock)
[![CodeFactor](https://www.codefactor.io/repository/github/david63/schedulelock/badge)](https://www.codefactor.io/repository/github/david63/schedulelock)

[![Compatible](https://img.shields.io/badge/compatible-phpBB:3.3.x-blue.svg)](https://shields.io/)

## Minimum Requirements
* phpBB 3.3.0
* PHP 7.1.3

## Install
1. [Download the latest release](https://github.com/david63/schedulelock/archive/3.3.zip) and unzip it.
2. Unzip the downloaded release and copy it to the `ext` directory of your phpBB board.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Schedule topic lock` under the Disabled Extensions list and click its `Enable` link.

## Usage
1. Navigate in the ACP to `Extensions -> Schedule topic lock -> Schedule topic lock`.
2. Apply the settings that you require.
3. Set the `Can schedule topic lock` permission for the groups/users that are able to schedule topic locking.
4. Navigate in the ACP to `Forums` and set the `Schedule topic lock` option for the forums that are able to have topics scheduled to be locked if the `All forums` option was not selected at point 2 above.

## Uninstall
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Schedule topic lock`.
3. To permanently uninstall, click `Delete Data`, then delete the schedulelock folder from `phpBB/ext/david63/`.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2021 - David Wood
