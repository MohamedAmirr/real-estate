## Contributing

- Create any feature branch from develop branch.

- Your branch name should follow the pattern [TYPE]/[WHAT_THE_MR_DO] like fix/deleted_users_show_in_search.

- Before pushing any changes make sure to:

- Run the PHP CS Fixer linter with `vendor/bin/php-cs-fixer fix --diff --config style.php_cs`.

- Run PHPStan static analysis with `vendor/bin/phpstan analyse --memory-limit=-1`.

- Run the test suite with `docker-compose exec app php artisan test`.

- Commits must follow the style guide line [here](https://github.com/angular/angular/blob/main/CONTRIBUTING.md#-commit-message-format)

- Create a merge request following the template in `.gitlab/merge_request_templates/default.md`.

- Your merge request title should follow the pattern [JIRA ISSUE Number] Type (Epic Name): Issue Title for example [OSH-405] Feat (Booking): Delete Auction.

