
# mazarini/paginator-bundle
Base to build Entity
## Installation
```console
foo@bar:~$ composer require mazarini/paginator-bundle
```
## Utilisation
Extends Mazarini\PaginatorBundle\Repository\EntityRepository allow method fillPage() to populate a paginator.

Paginator just need to know :
* line per page (setPerPage()),
* current page (setCurrentPage()), if null given then unlimited lines in one page,
* criterias to select only some lines (cf findBy())
* orderBy to order lines (cf findBy())
