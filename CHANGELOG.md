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

- Add psalm @core23 (#72)

# 2.1.0

## Changes

- Add missing strict file header @core23 (#47)

## 🚀 Features

- Add support for symfony 5 @core23 (#36)
- Add support for PSR http client @core23 (#41 #57)

## 🐛 Bug Fixes

- Fix calling psr request factory @core23 (#44)
