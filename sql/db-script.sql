DROP DATABASE IF EXISTS rule_assignment_system;

CREATE DATABASE rule_assignment_system 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE rule_assignment_system;

-- 1. RULES TABLE (Master)
CREATE TABLE rules (
    rule_id INT AUTO_INCREMENT PRIMARY KEY,
    rule_name VARCHAR(255) NOT NULL,
    rule_type ENUM('CONDITION', 'DECISION') NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. GROUPS TABLE
CREATE TABLE groups (
    group_id INT AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(255) NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. HIERARCHY TABLE
CREATE TABLE group_rule_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    group_id INT NOT NULL,
    rule_id INT NOT NULL,
    parent_id INT NULL,
    
    tier TINYINT NOT NULL,

    FOREIGN KEY (group_id) REFERENCES groups(group_id) ON DELETE CASCADE,
    FOREIGN KEY (rule_id) REFERENCES rules(rule_id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES group_rule_assignments(id) ON DELETE CASCADE,

    CHECK (tier BETWEEN 1 AND 3),

    UNIQUE (group_id, parent_id, rule_id),

    INDEX idx_group (group_id),
    INDEX idx_parent (parent_id)
);