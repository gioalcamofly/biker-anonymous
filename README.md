## Biker anonymous

***Requirements***

- Have Docker installed on your device with WSL2

***Installation***

- Pull this repository on your local machine
- Open a terminal and enter `wsl` to enter Linux Kernel
- Install composer dependencies: 
  
  `docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs`
- On the project root, execute `alias sail="bash ./vendor/bin/sail`
- Execute `sail up` (This will start the Docker services)

***Usage***

Once the Docker services are up and running, you can test the API endpoints on `localhost:80`. In the file biker-anonymous.postman_collection.json you have an example of how to properly use the API. 

IMPORTANT: there are some API routes that requires an authorization token. To get this token you should register a new user (`/api/register`) and take the access token given in the response. If you have already created an user, you should log in (`/api/login`) with your data and take the access token given. This token has to be copied on the header of the other requests (register and login are the only ones that don't need authentication). The header should be like this: `Authorization:Bearer [YOUR_TOKEN]`.

*Admin User*

By default, all the users created will have an 'employee' role. With that role, it's unathourized to use the endpoint `/api/send-email`, only users with 'admin' role can. For security reasons, in the public endpoint it's not available the creation of an 'admin' user, only another admin can do it. If you don't have another admin (first time using this project), you will have to manually edit the database. After doing so, you will be able to create another admin users using the endpoint `/api/register-admin`.

*E-mails*

To see the emails sent using the endpoint `/api/send-email` you have to access the Mailhog browser in `localhost:8025`.

*Cron Job*

There is a scheduled job to be executed daily at 23:30 to process the CSV files with the licenses. To execute that, it's necessary to add a cron job on your machine that executes the command `sail artisan schedule:run`. Linux example:

`30 23 * * * cd /path-to-your-project && ./vendor/bin/sail artisan schedule:run >> /dev/null 2>&1`






