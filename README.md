## Coalition Test

This is a simple Product Management system. The goal of the task is to:

- Be able to add products' quantity and unit price
- Save the above in a json file (in storage)
- View list of all saved products in a table on same page
- Sum up all total price on the table
- Edit a product
- Delete a product

## Specifications

Below are the specifications of dependencies:

- Laravel version 11
- PHP version 8.3

Before you start, ensure you have the following installed:

- Docker (up-to-date will be just fine)
- PHP version 8.3 or later
- Web browser
- Shell terminal environment

## Setting up the project locally

Before you start, ensure you have the following installed:

- Docker (up-to-date will be just fine)
- PHP version 8.3 or later
- Web browser
- Shell terminal environment

## Getting Started

1. **Clone the repository:**

   ```bash
   git clone https://github.com/degod/coalition.git
   ```

2. **Navigate to the project directory:**

	```bash
	cd coalition/
	```

3. **Install Composer dependencies:**

	```bash
	docker-compose up --build -d
	```

4. **Start the application with Laravel Sail:**

	```bash
	docker exec -it coalition-test-app composer install && cp .env.example .env
	```

5. **Logging in to container shell:**

	```bash
	docker exec -it coalition-test-app bash
	```

6. **Exiting container shell:**

	```bash
	exit
	```

7. **Accessing the application:**

- The application should now be running on your local environment.
- Navigate to `http://localhost:8084` in your browser to access the application.

8. **Stopping the application:**

	```bash
	docker-compose down
	```

## Contributing

If you encounter bugs or wish to contribute, please follow these steps:

- Fork the repository and clone it locally.
- Create a new branch (`git checkout -b feature/fix-issue`).
- Make your changes and commit them (`git commit -am 'Fix issue'`).
- Push to the branch (`git push origin feature/fix-issue`).
- Create a new Pull Request against the `main` branch, tagging `@degod`.

## Contact

For inquiries or assistance, you can reach out to Godwin Uche:

- `Email:` degodtest@gmail.com
- `Phone:` +2348024245093
