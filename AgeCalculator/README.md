# 🐳 Dockerized Age Calculator Application

![Age Calculator Screenshot](./public/AgeCalculator.jpg)


## 🧰 How to Run Any Project

1. **Clone the Repository in your Machine**
    ```bash
    git clone https://github.com/faizan619/Docker_PHP_Laravel_Projects.git
    ```

2. **Navigate to the project folder:**

    ```bash
    cd AgeCalculator
    ```

3. **Build and run the Docker container:**

    ### Run Command in the CLI

    > **Dockerized Using DockerFile**

    1. **Build the Docker Image of the Project**
        ```bash
        docker build -t age-calculator-image
        ```
    
    2. **Setup the Container using the Docker Image**
        ```bash
        docker run -p 7300:80 --rm --name age-calculator-container age-calculator-image
        ```
    
    3. **Visit in your browser**
        ```bash
        http://localhost:7300/
        ```

    4. **Stop the Container**
        ```
        press CTRL+C
        ```

        ---

    > **Dockerized Using Docker Compose**
    
    1. **Run the Docker Compose Command**
        ```bash
        docker compose up -d --build
        ```
    
    2. **Visit in your browser**
        ```bash
        http://localhost:7300
        ```
    
    3. **Stop the Container**
        ```bash
        docker compose stop
        ```
    
    4. **Delete the Container**
        ```bash
        docker compose down
        ```

---

> ⭐ Star this repo if you find these projects useful!  

> 💬 Feel free to open issues or contribute improvements.

