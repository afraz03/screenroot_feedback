CREATE DATABASE IF NOT EXISTS screenroot_feedback
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE screenroot_feedback;

CREATE TABLE IF NOT EXISTS feedback (
  id                   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name                 VARCHAR(120) NOT NULL,
  email                VARCHAR(190) NOT NULL,
  company              VARCHAR(160) NULL,
  project              VARCHAR(160) NULL,
  overall_rating       TINYINT UNSIGNED NOT NULL,   -- 1 to 5
  communication_rating TINYINT UNSIGNED NOT NULL,   -- 1 to 5
  design_rating        TINYINT UNSIGNED NOT NULL,   -- 1 to 5
  timeliness_rating    TINYINT UNSIGNED NOT NULL,   -- 1 to 5
  nps_score            TINYINT UNSIGNED NOT NULL,   -- 0 to 10
  went_well            TEXT NULL,
  improve              TEXT NULL,
  can_contact          TINYINT(1) NOT NULL DEFAULT 0,
  ip_hash              CHAR(64) NULL,
  created_at           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_created (created_at),
  INDEX idx_overall (overall_rating),
  INDEX idx_ip (ip_hash, created_at)
) ENGINE=InnoDB;
