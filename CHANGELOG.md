# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

##[2.0.1]()
### Changed
- Website landing page copy.

## [2.0.0](https://gitlab.com/jrswab/nebulus/commit/111c2c7b72466519ed62717bb652f8c8fec50f8e)
### Added
- Ability to pin hashes on home page without an account
- Node directory to hold node scripts and for future Docker file.
- Ability to send node live status with custom json for future needs.
- A config file to hold user info such as steem account and wif location.

### Changed
- pin.py to remove unneeded lines and modules
- execs/pin.py to node/pin.py for furture Docker file
- All files called by python for data now held in config/

### Removed
- Creation of new user profile pages
- Creation of new user feeds
- Login link for user accounts
- User file upload uploads

### Deprecated
- RSS feeds
- Profile pages
- New user account creation

## [1.0.0](https://gitlab.com/jrswab/nebulus/commit/b585d3b4137c354e17e930dbb5bb766ebf3dbffc) - 2018-08-27
### Added
- This changelog
