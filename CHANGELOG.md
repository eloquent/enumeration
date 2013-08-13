# Enumeration changelog

### 4.0.0 (2013-08-13)

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

### 3.0.2 (2013-03-04)

- **[NEW]** [Archer] integration
- **[NEW]** Implemented changelog

[Archer]: (https://github.com/IcecaveStudios/archer)
