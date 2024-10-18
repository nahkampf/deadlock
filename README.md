# ĐɆ₳ĐⱠØ₵₭

__deadlock__ is a multiplayer cyberpunk door game (meant to be run on BBSes). 

## Requirements
- PHP 7.4 (or higher) with the following modules enabled
    - `readline`
    - `PDO`
    - `sqlite3`
- Composer
- A linux or unix environment (since the Windows implementation of `readline` doesn't support reading keypresses).

## Install
Download a release and put it where your other doors are (e.g `/sbbs/xtrn/deadlock` for SynchroNet), then run:

```
composer install
```

There are some settings in `config.ini` that you can change (you don't have to).

### Setup: Synchronet
Run `scfg` and add a new external program. It should have the following settings:
- Start up directory: Where you put deadlock (most often `../xtrn/deadlock`)
- Command line: `<php path> start.php --dropfile=%f --type=door32` (replace `<php path>` with the path to the php binary, often `/usr/bin/php`)
- I/O Method: `Standard` (no WWIV color).
- Native executable: `Yes`
- Use shell or new context: `Yes`
- BBS Drop file type: `door32.sys`

### Setup: Mystic BBS
Currently untested, but Mystic has `%P` (path to dropfile) in their command line exucutor so you should be able to try it.

### Setup: Others (or running locally)
Deadlock can be run locally as well (ie just for your own pleasure), and can probably be run on other BBS systems that doesn't support DOOR.SYS or DOOR32.SYS by passing some arguments to `start.php`. The following switches are available:

- `--userid` - The ID number of the user (must be an integer)
- `--minutes` - How many minutes the user has left this call (optional).
- `--handle` - The users handle/alias, in order to preopulate their character name (optional)

If running locally you probably want a good terminal emulator (capable of ANSI.SYS-capable escape codes and CP437 charset).