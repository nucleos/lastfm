# 3.1.0

## Changes

## 📦 Dependencies

- Add support for PHP 8 @core23 (#151)
- Drop support for PHP 7.2 @core23 (#83)

# 3.0.1

## Changes

## 🐛 Bug Fixes

- Clean broken address data [@core23] ([#77])

# 3.0.0

## Changes

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
  
## 🚀 Features

- Add psalm [@core23] ([#72])

# 2.1.0

## Changes

- Add missing strict file header [@core23] ([#47])

## 🚀 Features

- Add support for symfony 5 [@core23] ([#36])
- Add support for PSR http client [@core23] ([#41] [#57])

## 🐛 Bug Fixes

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
