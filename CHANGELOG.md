# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v0.9.0] - 2019-07-12

### Added
- Optimized code base
- Using new `response()->ApiError()`
- Using new `response()->Api()`
- Integrated users permissions as scopes in api token when available
- Using new check http header `accept` and `content-type` middleware
- Fix cross domain cookies availability when httpOnly config on 
- Cookie http only config value stored using .env

### Changed
- Remove log refresh when user refresh access token

### Removed


[v0.9.0]: https://github.com/consigliere/Passerby/releases/tag/v0.9.0
