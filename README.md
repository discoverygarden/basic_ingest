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
any further configuration. These include:

* Some CSS to improve the user experience during ingest
* Automatic suppression of fields with options (checkboxes, select fields, and
radio buttons) if no options are present
* Optional automatic redirection to a parent node when submitting Media that are
media of the given node
* Optional automatic redirection to the Media submission form when creating
nodes that expect media
* Automatic selection and suppression of display hints when they're in the
Media type mapping
* Suppression of the PID field during Resource Item creation
* Suppression of the show/hide row weights link

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
