# eSignature Documentation

## Project Description

The **eSignature** application is an advanced digital signature platform designed to allow users to securely sign and manage documents online. Utilizing cutting-edge web technologies, it ensures top-notch security and compliance standards. The application is built on Laravel for backend services, offering a seamless and efficient user experience.

## Technologies and Tools

- **PHP 8.3**
- **Laravel 10**
- **MySQL 8.0**
- **Docker**
- **Redis**
- **MailHog**

## Environment Setup

Follow these steps to set up the eSignature application:

1. **Install Docker:** Ensure the latest version of Docker is installed on your machine.
2. **Clone the Project:** Clone the project repository from GitHub using the command:
    ```sh
    git clone <repository-url>
    ```
3. **Navigate to the Project Directory:** Open a terminal and navigate to the project directory:
    ```sh
    cd project-directory
    ```
4. **Build the Docker Containers:** Run the following command to build the necessary Docker containers:
    ```sh
    docker-compose build
    ```
5. **Start the Docker Containers:** Use the following command to start the Docker containers:
    ```sh
    docker-compose up
    ```

Once setup is complete, the following Docker containers should be running:

- `esignature-redis`
- `esignature-mailhog`
- `esignature-mysql`
- `esignature-php-fpm`
- `esignature-php-nginx`

### Notes

1. **Automatic Setup:** Docker installation will automatically install all necessary components and run migrations. If any errors occur, SSH into the Docker container and run:
    ```sh
    composer install
    php artisan migrate
    ```
2. **Mac OS Focus:** This Docker setup is primarily designed for **Mac OS**. It is recommended to use a Mac for testing.
3. **Port Configuration:** To change the Docker ports, modify the `.env` file accordingly.

## Run Queue Service

The application uses Laravel's queue service to handle email and background jobs. To run the queue manually, follow these steps:

1. **SSH into the Docker Container:** Access the `esignature-php-fpm` container:
    ```sh
    docker exec -it esignature-php-fpm /bin/bash
    ```
2. **Run the Queue:** Execute the following command:
    ```sh
    php artisan queue:work
    ```

## How to Access the Tools

### API Access

Access the API via: [http://localhost:8088](http://localhost:8088)

### Mail Server

Access the Mail server via: [http://localhost:8027](http://localhost:8027)

### API Activities and Logs

Access API activities and logs via: [http://localhost:8088/telescope](http://localhost:8088/telescope)

## Assets

For testing purposes, the following assets can be found in the project's `Samples` directory:

1. **Sample PDF:** `Sample.pdf`
2. **Sample Signature:** `signature.png`
3. **Postman Collection:** `eSignature.postman_collection.json`

## API Documentation

- **Option 1:** [Postman Documentation](https://documenter.getpostman.com/view/28765014/2sA3dygAkP)
- **Option 2:** Postman Collection file: `Samples/eSignature.postman_collection.json`

## Workflow

1. User registration
2. After the registration user needs to verify the email address
3. Upload the documents (Use the sample pdf)
4. Share the document with other users
5. The invites user can upload the signature
6. The system will store the signature and create the new PDF with signature (Refer `signed-document.pdf`)

## Architecture

The backend application utilizes the Laravel framework and follows the **Service Repository** pattern.

### Advantages of Service Repository Pattern in Laravel

1. **Separation of Concerns:**
   - **Repositories:** Handle data retrieval and storage, organizing the codebase.
   - **Services:** Encapsulate business logic, keeping it separate from data access logic.
2. **Testability:** 
   - Isolate business logic in services and data access in repositories for easier mocking and unit testing.
3. **Maintainability:**
   - Clear separation between application layers makes maintenance and extension easier.
4. **Reusability:**
   - Reuse repository methods across services and use services in different controllers.
5. **Readability and Clean Code:**
   - Adherence to this pattern results in a cleaner, more readable codebase.
6. **Encapsulation:**
   - Repositories encapsulate data access logic, allowing for changes without affecting the rest of the application.
7. **Consistency:**
   - Consistent pattern implementation improves overall code consistency.
8. **Scalability:**
   - Clear structure and separation of concerns facilitate easier scaling and feature addition.

## Improvements

1. **API Expansion:** Implement additional CRUD operations for comprehensive functionality.
2. **Dynamic Signature Positions:** Allow users to define signature positions, accommodating various document layouts.
3. **Bulk Import Feature:** Enable bulk imports to facilitate sharing with multiple users.
4. **External Storage Integration:** Utilize external storage solutions for file management.
5. **Signature Encryption:** Ensure all signature images are encrypted for enhanced security.
