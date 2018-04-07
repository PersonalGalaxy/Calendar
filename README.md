# Calendar

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/badges/build.png?b=master)](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/PersonalGalaxy/Calendar/build-status/develop) |

Model to manage a calendar.

## Installation

```sh
composer require personal-galaxy/calendar
```

## Usage

The only entry point to use the model are the [commands](src/Command), you should use a [command bus](https://github.com/innmind/commandbus) in order to bind the commands to their handler.

You also need to implement the repository [interfaces](src/Repository) in order to persist the agendas and events.
