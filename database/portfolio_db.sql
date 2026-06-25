-- Create Database
CREATE DATABASE IF NOT EXISTS epiz_28973647_rdf;
USE epiz_28973647_rdf;

-- Projects Table
CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(500),
    technologies TEXT,
    project_url VARCHAR(500),
    github_url VARCHAR(500),
    category VARCHAR(100),
    status ENUM('published', 'draft') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- About Content Table
CREATE TABLE IF NOT EXISTS about_content (
    id INT PRIMARY KEY AUTO_INCREMENT,
    section_name VARCHAR(100) NOT NULL,
    content TEXT,
    image VARCHAR(500),
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Skills Table
CREATE TABLE IF NOT EXISTS skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact Info Table
CREATE TABLE IF NOT EXISTS contact_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    info_type VARCHAR(50) NOT NULL,
    label VARCHAR(100),
    value VARCHAR(255) NOT NULL,
    icon_class VARCHAR(100),
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Social Media Table
CREATE TABLE IF NOT EXISTS social_media (
    id INT PRIMARY KEY AUTO_INCREMENT,
    platform VARCHAR(50) NOT NULL,
    url VARCHAR(500) NOT NULL,
    icon_svg TEXT,
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users Table for Admin Authentication
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'editor') DEFAULT 'admin',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Admin User (username: admin, password: admin123)
INSERT INTO users (username, password, email, full_name, role) VALUES
('admin', '$2y$10$Q4twQD6jOqRv8thlwLLuJug4YvVLK.QAcfXQZwjoCWTXQfZcNuMCu', 'admin@example.com', 'Administrator', 'admin');

-- Insert Default Data

-- Default About Content
INSERT INTO about_content (section_name, content, order_num) VALUES
('hero_title', 'Restian Dwi Friwaldi', 1),
('hero_subtitle', 'Front-End Developer & Graphic Designer', 2),
('hero_description', 'I am an enthusiastic web developer and graphic designer located in Serang, Banten, Indonesia. I am constantly exploring new programming languages and actively improving my skills in web and mobile development, UI/UX, and data science.', 3),
('education', '🎓 Bachelor of Informatics – Yogyakarta Technology University', 4),
('certification_1', '🏆 Finalist LKS SMK 2020 - Cybersecurity', 5),
('certification_2', '📜 RapidMiner Data Engineering Professional & freeCodeCamp Responsive Web Design Certified.', 6);

-- Default Skills
INSERT INTO skills (category, skill_name, order_num) VALUES
('Frontend', 'HTML5', 1),
('Frontend', 'CSS3', 2),
('Frontend', 'JavaScript', 3),
('Frontend', 'React', 4),
('Frontend', 'Tailwind CSS', 5),
('Backend', 'PHP', 6),
('Backend', 'Laravel', 7),
('Backend', 'Node.js', 8),
('Backend', 'Python', 9),
('Database', 'MySQL', 10),
('Database', 'PostgreSQL', 11),
('Database', 'MongoDB', 12),
('Tools', 'Git', 13),
('Tools', 'Docker', 14),
('Tools', 'VS Code', 15),
('Tools', 'Figma', 16);

-- Default Contact Info
INSERT INTO contact_info (info_type, label, value, icon_class, order_num) VALUES
('email', 'Email', 'restiandf@gmail.com', 'email', 1),
('phone', 'Phone', '+62 812-3456-7890', 'phone', 2),
('location', 'Location', 'Serang, Banten, Indonesia', 'location', 3);

-- Default Social Media
INSERT INTO social_media (platform, url, icon_svg, order_num) VALUES
('github', 'https://github.com/restiandf', '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>', 1),
('linkedin', 'https://linkedin.com/in/restiandf', '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>', 2),
('twitter', 'https://twitter.com/restiandf', '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>', 3);

-- Default Projects
INSERT INTO projects (title, description, image, technologies, project_url, github_url, category, status) VALUES
('Wonderland', 'A beautiful tourism website built with ReactJS and Tailwind CSS featuring modern UI/UX design.', 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&q=80', 'ReactJS,Tailwind', 'https://restiandf.my.id/pariwisata/', '', 'Web Development', 'published'),
('Teras Online', 'E-commerce platform with secure payment integration and inventory management system.', 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=800&q=80', 'PHP,MySQL', 'https://ubeltech.rf.gd/Ecommerce/', '', 'E-Commerce', 'published'),
('Weather Forecast', 'Real-time weather application with location-based forecasts using external APIs.', 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=800&q=80', 'JavaScript,APIs', 'https://prediksi-cuaca.vercel.app/', '', 'Web App', 'published'),
('AI Chatbot', 'Intelligent chatbot powered by OpenRouter API with natural language processing capabilities.', 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=800&q=80', 'OpenRouter,PHP', '', '', 'AI/ML', 'draft'),
('Artisan Coffee', 'Modern coffee shop website with online ordering and reservation system.', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=800&q=80', 'HTML5,JavaScript', 'https://coffe-lake.vercel.app/', '', 'Web Development', 'published');