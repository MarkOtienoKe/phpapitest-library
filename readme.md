The php code test for a PHP library that consumes endpoints.php file and pings each of the listed endpoints tracking 
                      
                      1. The time the request was made (timestamp)
                      2. The server response code
                      3. The total response time
                      
         It also Captures the 3 data points above in response_time.csv file

To run the library, clone the project,

create a database with a table with the following columns
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(100),
    method VARCHAR(30),
    request_time TIMESTAMP,
    server_response_code INT(6),
    total_response_time  double
    
    
