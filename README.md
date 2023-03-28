# DocumentSearch

### Usage

```shell
php main.php "your search term here"
```

```
$ php main.php "Hallelujiah acoustic Boog"
Array
(
    [data/hack11a.txt] => Array
        (
            [document] => data/hack11a.txt
            [matching words] => Array
                (
                    [0] => acoustic
                )

            [relevance] => 8.333174769722E-5
        )

    [data/b00g!.hum] => Array
        (
            [document] => data/b00g!.hum
            [matching words] => Array
                (
                    [0] => Hallelujiah
                    [1] => acoustic
                    [2] => Boog
                )

            [relevance] => 0.015173626042777
        )

)
```