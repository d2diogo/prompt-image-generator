-- Database installation script
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);
INSERT INTO users (username, password) VALUES ('admin', SHA2('admin123', 256));

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  active TINYINT DEFAULT 1
);

CREATE TABLE options (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  prompt_value VARCHAR(255) NOT NULL,
  description TEXT,
  image_path VARCHAR(255),
  sort_order INT DEFAULT 0,
  active TINYINT DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Exemplo de dados iniciais
INSERT INTO categories (name) VALUES ('Estilo Fotográfico'), ('Plano'), ('Ângulo');
INSERT INTO options (category_id, name, prompt_value) VALUES
(1, 'editorial', 'editorial'),
(1, 'lifestyle', 'lifestyle'),
(2, 'close-up', 'close-up'),
(2, 'plano geral', 'wide shot'),
(3, 'olho-no-olho', 'eye level');
