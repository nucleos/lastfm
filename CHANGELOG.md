# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 3.3.1 - TBD

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.3.0 - 2022-01-14


-----

### Release Notes for [3.3.0](https://github.com/nucleos/lastfm/milestone/3)

Feature release (minor)

### 3.3.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **2**

#### Enhancement

 - [348: Use shared pipelines](https://github.com/nucleos/lastfm/pull/348) thanks to @core23
 - [338: Remove composer-bin plugin](https://github.com/nucleos/lastfm/pull/338) thanks to @core23

#### dependency

 - [335: Update psr/log requirement from ^1.0 to ^1.0 || ^2.0 || ^3.0](https://github.com/nucleos/lastfm/pull/335) thanks to @dependabot[bot]

## 3.2.0 - 2021-12-06



-----

### Release Notes for [3.2.0](https://github.com/nucleos/lastfm/milestone/1)



### 3.2.0

- Total issues resolved: **0**
- Total pull requests resolved: **4**
- Total contributors: **1**

#### dependency

 - [334: Drop symfony 4 support](https://github.com/nucleos/lastfm/pull/334) thanks to @core23
 - [328: Drop PHP 7 support](https://github.com/nucleos/lastfm/pull/328) thanks to @core23

#### Enhancement

 - [333: Update tools and use make to run them](https://github.com/nucleos/lastfm/pull/333) thanks to @core23
 - [277: Remove LoggerAwareTrait to resolve null error](https://github.com/nucleos/lastfm/pull/277) thanks to @core23

## 3.1.0

### Changes

### 📦 Dependencies

- Add support for PHP 8 [@core23] ([#151])
- Drop support for PHP 7.2 [@core23] ([#83])

## 3.0.1

### Changes

### 🐛 Bug Fixes

- Clean broken address data [@core23] ([#77])

## 3.0.0

### Changes

- Renamed namespace `Nucleos\LastFm` to `Nucleos\LastFm` after move to [@nucleos]

  Run

  ```
  $ composer remove core23/lastfm-api
  ```

  and

  ```
  $ composer require nucleos/lastfm
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Nucleos\\LastFm/Nucleos\\LastFm/g' {} \;
  ```

  to replace occurrences of `Nucleos\LastFm` with `Nucleos\LastFm`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

### 🚀 Features

- Add psalm [@core23] ([#72])

## 2.1.0

### Changes

- Add missing strict file header [@core23] ([#47])

### 🚀 Features

- Add support for symfony 5 [@core23] ([#36])
- Add support for PSR http client [@core23] ([#41] [#57])

### 🐛 Bug Fixes

- Fix calling psr request factory [@core23] ([#44])

[#77]: https://github.com/nucleos/lastfm/pull/77
[#72]: https://github.com/nucleos/lastfm/pull/72
[#57]: https://github.com/nucleos/lastfm/pull/57
[#47]: https://github.com/nucleos/lastfm/pull/47
[#44]: https://github.com/nucleos/lastfm/pull/44
[#41]: https://github.com/nucleos/lastfm/pull/41
[#36]: https://github.com/nucleos/lastfm/pull/36
[@nucleos]: https://github.com/nucleos
[@core23]: https://github.com/core23
[#151]: https://github.com/nucleos/lastfm/pull/151
[#83]: https://github.com/nucleos/lastfm/pull/83
