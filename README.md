GH Archive Keyword
==================

## Prerequisites

- PHP >= 7.4 with libs : curl wget bash unzip
- MySQL >= 5.6

## Setup

- Copy .env file to .env.local file and change the following line with your MySQL config : 

```
DATABASE_URL=mysql://root:root@db:3306/yousign
```

- Run migrations with following command : 

```
php bin/console --no-interaction d:m:m
```

## Run tests

No database is required for tests

### Unit Tests

To run unit tests, run the following command : 

```
make unit-tests
``` 
### Integration Tests

To run integration tests, run the following command : 

```
make integration-tests
``` 

### Run Tests

To run unit + integration tests, run the following command : 

```
make run-tests
``` 

## Import data

Data from GH Archive can be imported with this command : 

```
php bin/console commit:import <year> <month> <day> <?replace>

# <year> is a YYYY format
# <month> is a MM format
# <day> is a DD format
# <replace> is optionnal, if set to "yes", it will replace imported data for specified date
```

## Request data

To get stats data for specific date and keyword, you can make a `GET` request to the route ``/commit?date=<date>&keyword=<keyword>`` with the following parameters : 

| Parameter | Value                             |
|-----------|-----------------------------------|
| date      | YYYY-MM-DD                        |
| keyword   | `string` (minimum 3 characters)   |


## Error Response from API

In case of error, you'll get a JSON response with the keys : 

```
<code:integer> => The HTTP Error Code (ex : 400)
<message:string> => The error message
<content:null> => A null value
```

Here is an example response : 

```
{
    "code": 400,
    "message": "Missing parameter keyword",
    "content": null
}
```

## Success Response from API

In case of success, you'll get a JSON response with the keys : 

```
<code:integer> => The HTTP Success Code : 200
<message:string> => An empty string
<content:object> => The payload of the response with the data for specified date and keyword
```

The ``content`` key contains the following payload : 

```
<date:string> => The date string specified in parameter
<keyword:string> => The keyword specified in parameter
<total:integer> => The total number of occurences for the keyword <keyword> and the date <date>
<dataByEventType:object> => The stats by eventType (more details in example response)
<lastCommits:array> => The 5 last commits for the specified keyword (more details in example response)
```

Here is an example response : 

```
{
    "code": 200,
    "message": "",
    "content": {
        "date": "2020-10-01",
        "keyword": "love",
        "total": 556,
        "dataByEventType": {
            "PushEvent": {
                "0": 21,
                "1": 24,
                "2": 36,
                "3": 27,
                "4": 38,
                "5": 25,
                "6": 0,
                "7": 0,
                "8": 0,
                "9": 0,
                "10": 0,
                "11": 0,
                "12": 0,
                "13": 0,
                "14": 0,
                "15": 0,
                "16": 0,
                "17": 0,
                "18": 0,
                "19": 0,
                "20": 0,
                "21": 0,
                "22": 0,
                "23": 0,
                "total": 171
            },
            "IssueCommentEvent": {
                "0": 33,
                "1": 37,
                "2": 48,
                "3": 46,
                "4": 77,
                "5": 88,
                "6": 0,
                "7": 0,
                "8": 0,
                "9": 0,
                "10": 0,
                "11": 0,
                "12": 0,
                "13": 0,
                "14": 0,
                "15": 0,
                "16": 0,
                "17": 0,
                "18": 0,
                "19": 0,
                "20": 0,
                "21": 0,
                "22": 0,
                "23": 0,
                "total": 329
            },
            "CreateEvent": {
                "0": 3,
                "1": 4,
                "2": 5,
                "3": 8,
                "4": 6,
                "5": 17,
                "6": 0,
                "7": 0,
                "8": 0,
                "9": 0,
                "10": 0,
                "11": 0,
                "12": 0,
                "13": 0,
                "14": 0,
                "15": 0,
                "16": 0,
                "17": 0,
                "18": 0,
                "19": 0,
                "20": 0,
                "21": 0,
                "22": 0,
                "23": 0,
                "total": 43
            },
            "CommitCommentEvent": {
                "0": 1,
                "1": 2,
                "2": 3,
                "3": 3,
                "4": 3,
                "5": 1,
                "6": 0,
                "7": 0,
                "8": 0,
                "9": 0,
                "10": 0,
                "11": 0,
                "12": 0,
                "13": 0,
                "14": 0,
                "15": 0,
                "16": 0,
                "17": 0,
                "18": 0,
                "19": 0,
                "20": 0,
                "21": 0,
                "22": 0,
                "23": 0,
                "total": 13
            }
        },
        "lastCommits": [
            {
                "repositoryName": "spadeloves/cybouz_automatic_approval",
                "repositoryUrl": "https://api.github.com/repos/spadeloves/cybouz_automatic_approval",
                "message": "Merge branch 'master' of https://github.com/spadeloves/cybouz_automatic_approval",
                "commitId": "13698529968"
            },
            {
                "repositoryName": "indianbhaiya/IndianBot",
                "repositoryUrl": "https://api.github.com/repos/indianbhaiya/IndianBot",
                "message": "Merge pull request #39 from BLUE-DEVIL1134/master\n\n@pureindialover, Merge fast",
                "commitId": "13698527996"
            },
            {
                "repositoryName": "xyz195/check_out",
                "repositoryUrl": "https://api.github.com/repos/xyz195/check_out",
                "message": "Merge pull request #3 from jojo9910/master\n\nadding lovely unicorn",
                "commitId": "13698498200"
            },
            {
                "repositoryName": "xyz195/check_out",
                "repositoryUrl": "https://api.github.com/repos/xyz195/check_out",
                "message": "added lovely unicorn",
                "commitId": "13698498200"
            },
            {
                "repositoryName": "arxtic/psight",
                "repositoryUrl": "https://api.github.com/repos/arxtic/psight",
                "message": "spread some love",
                "commitId": "13698493154"
            }
        ]
    }
}
```
