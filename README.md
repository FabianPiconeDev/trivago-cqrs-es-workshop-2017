### Basic CQRS and Event Sourcing with Prooph

This is an example application aimed at teaching basic event sourcing.

#### Requirements

To run this application, you will need:

 * [PHP 7](https://secure.php.net/downloads.php)
 * [composer](https://getcomposer.org/)
 * [ext-pdo](http://php.net/manual/en/book.pdo.php)
 * [ext-pdo_sqlite](http://php.net/manual/en/ref.pdo-sqlite.php)

#### Toolchain

The tools that we are going to use are:

 * [Zend Expressive](https://github.com/zendframework/zend-expressive) a simple PSR-7/HTTP routing framework
 * [Prooph Components](https://github.com/prooph/) abstraction for common CQRS + Event Sourcing concerns

#### Domain of the app

The domain of the application is quite limited, but sufficient to explain how and when to effectively use
CQRS and EventSourcing.

The MVP of the application has following specification:

 * assume that each person interacting with the system has a badge with a username on it
 * assume that the username is given: we assume that the input data is already validated against existing users
 * track people entering (check-in) a building
 * track people leaving (check-out) a building
 * prevent people from double-entering a building (security concern)
 * prevent people from double-leaving a building (security concern)
 * allow querying a list of people that are currently in the building

#### Build steps

Following steps are to be implemented:

- [x] Ability to register a new building (already provided)
- [x] Ability to check-in with a username and a building identifier (skeleton code provided)
- [x] Ability to check-out with a username and a building identifier (skeleton code provided)
- [x] Provide console output (STDERR) every time a check-in happens (event handler)
- [x] Provide console output (STDERR) every time a check-out happens (event handler)
- [x] Provide a file per building (accessible via HTTP) with usernames of currently checked-in persons

#### Additional notes from the forker
- [x] Prevent people from double check-in
- [x] Prevent people from double check-out

##### Proccess summary starting from a command until the domain event is being written
1. Command (contains only a payload) is registered in the container
2. Command registration returns a callable for latter execution
3. Command gets passed to the CommandBus (web layer)
4. CommandBus calls listener
5. Listener executes code from the command registered callable
6. Callable gets an aggregate and performs an action
7. The action creates an domain event

Specify one "when" method per domain event, otherwise the framework will crash. These methods are for
hydrating the aggregate from the event store.

Checking-in a user calls its "when" method:
1. Before check-in. By getting aggregate that is going to be hydrated, thus can be called multiple times
2. After check-in, one time again for ensuring the state change on this aggregate