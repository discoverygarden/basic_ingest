# Basic Ingest

## Introduction

Basic repository item ingest improvements.

## Requirements

This module requires the following modules/libraries:

* [Islandora](https://github.com/Islandora/islandora)
* [Prepopulate](https://www.drupal.org/project/prepopulate)

## Installation

Install as usual, see
[this](https://drupal.org/documentation/install/modules-themes/modules-8) for
further information.

## Configuration

Basic Ingest attempts to help out with the process of creating Media and
selecting display hints by by maintaining a mapping of Repository Item model
URIs to Media type IDs.

This mapping lives in the configuration at `basic_ingest.settings.map`, and
contains a list of mapping objects supporting the following structure:

* `uri`: the URI of the model to apply this mapping to
* `media_type`: the ID of the media type this model should be mapped to
* `display_hints`: a sequence of display hint URIs applicable to the given
Media type, to narrow down the selection list.

## Usage

Most of the improvements in this module appear automatically and don't require
any further configuration.

* Some CSS is provided to improve the user experience during ingest
* Fields with options (checkboxes, select fields, and radio buttons) are
automatically suppressed if they contain no options
* When Media are ingested, an option is given to automatically redirect to that
Media's parent
* When Repository Items are created that expect a Media to be attached, an
option is given to automatically redirect to the Media submission form
* Display hints can also be mapped to Media types so that the display hint
selection is suppressed
* The PID field is suppressed during Resource Item creation
* The link to show and hide row weights is suppressed

## Troubleshooting/Issues

Having problems or solved a problem? Contact
[discoverygarden](http://support.discoverygarden.ca).

## Maintainers/Sponsors

Current maintainers:

* [discoverygarden](http://www.discoverygarden.ca)

## Development

If you would like to contribute to this module create an issue, pull request
and or contact
[discoverygarden](http://support.discoverygarden.ca).

## License

[GPLv3](http://www.gnu.org/licenses/gpl-3.0.txt)
