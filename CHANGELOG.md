# Changelog

## 6.0.0 (2018-11-22)

- **[BC BREAK]** Dropped support for PHP < 7.1.
- **[IMPROVED]** Support for non-public enumeration constants ([#24], [#26])
  (thanks [@Bilge]).

[#24]: https://github.com/eloquent/enumeration/issues/24
[#26]: https://github.com/eloquent/enumeration/pull/26

## 5.1.1 (2015-11-04)

- **[IMPROVED]** Use `static` in docblocks for better IDE hints ([#20]) (thanks
  [@Bilge]).
- **[MAINTENANCE]** General repository maintenance

[#20]: https://github.com/eloquent/enumeration/pull/20
[@bilge]: https://github.com/Bilge

## 5.1.0 (2014-03-13)

- **[NEW]** Implemented `memberOrNullBy()` and variants

## 5.0.1 (2014-01-29)

- **[MAINTENANCE]** General repository maintenance

## 5.0.0 (2013-11-11)

- **[BC BREAK]** Renamed classes:
    - `Multiton` -> `AbstractMultiton`
    - `Enumeration` -> `AbstractEnumeration`
- **[BC BREAK]** Exceptions no longer extend `LogicException`, but instead
  directly extend from the base `Exception` class.
- **[NEW]** Implemented `AbstractValueMultiton`, an an abstract base class for
  implementing multitons with values. `AbstractEnumeration` now extends from
  this base class.
- **[NEW]** Implemented `AbstractUndefinedMemeberException`, an abstract base
  class for implementing custom undefined member exceptions.
  `UndefinedMemberException` now extends from this base class.
- **[NEW]** Multiton instances now implement formal interfaces:
    - `AbstractMultiton` instances implement `MultitonInterface`.
    - `AbstractValueMultiton` instances implement `ValueMultitonInterface`.
    - `AbstractEnumeration` instances implement `EnumerationInterface`
- **[NEW]** Implemented `membersBy()` and `membersByPredicate()` which help to
  retrieve sets of members by various criteria.

## 4.0.0 (2013-08-13)

- **[BC BREAK]** `Multiton` method name changes:
    - `multitonInstances` -> `members`
    - `instanceByKey` -> `memberByKey`
    - `instanceBy` -> `memberBy`
    - `instanceByPredicate` -> `memberByPredicate`
    - `initializeMultiton` -> `initializeMembers`
    - `registerMultiton` -> `registerMember`
    - `createUndefinedInstanceException` -> `createUndefinedMemberException`
- **[BC BREAK]** `Enumeration` method name changes:
    - `instanceByValue` -> `memberByValue`
- **[BC BREAK]** Renamed classes:
    - `UndefinedInstanceException` -> `UndefinedMemberException`
    - `UndefinedInstanceExceptionInterface` -> `UndefinedMemberExceptionInterface`
- **[NEW]** Case insensitive options for member search methods
- **[NEW]** Defaulting variants of member search methods
- **[MAINTENANCE]** General repository maintenance

## 3.0.2 (2013-03-04)

- **[NEW]** [Archer] integration
- **[NEW]** Implemented changelog

[archer]: (https://github.com/IcecaveStudios/archer)
