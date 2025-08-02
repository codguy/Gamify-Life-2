-- =============================================================================
-- LIFE QUEST APPLICATION - PRODUCTION DATABASE SCHEMA
-- =============================================================================
-- Author: Database Design for Gamified Life Dashboard
-- Version: 1.0
-- Date: July 2025
-- Description: Modular database schema with proper indexing and relationships
-- =============================================================================

-- =============================================================================
-- CORE SYSTEM TABLES
-- =============================================================================
CREATE DATABASE IF NOT EXISTS lifequest_db 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lifequest_db;

SET FOREIGN_KEY_CHECKS = 0;

-- Drop views first (they depend on tables)
DROP VIEW IF EXISTS vw_weekly_leaderboard;
DROP VIEW IF EXISTS vw_user_dashboard;

-- Drop tables in reverse dependency order
DROP TABLE IF EXISTS tbl_social_interactions;
DROP TABLE IF EXISTS tbl_social_activities;
DROP TABLE IF EXISTS tbl_user_friendships;
DROP TABLE IF EXISTS tbl_user_purchases;
DROP TABLE IF EXISTS tbl_shop_items;
DROP TABLE IF EXISTS tbl_leaderboard_entries;
DROP TABLE IF EXISTS tbl_leaderboard_periods;
DROP TABLE IF EXISTS tbl_journal_entries;
DROP TABLE IF EXISTS tbl_goal_logs;
DROP TABLE IF EXISTS tbl_goal_milestones;
DROP TABLE IF EXISTS tbl_goal_metadata;
DROP TABLE IF EXISTS tbl_user_achievements;
DROP TABLE IF EXISTS tbl_achievement_metadata;
DROP TABLE IF EXISTS tbl_habit_streaks;
DROP TABLE IF EXISTS tbl_habit_logs;
DROP TABLE IF EXISTS tbl_habit_metadata;
DROP TABLE IF EXISTS tbl_quest_logs;
DROP TABLE IF EXISTS tbl_user_quests;
DROP TABLE IF EXISTS tbl_quest_templates;
DROP TABLE IF EXISTS tbl_task_logs;
DROP TABLE IF EXISTS tbl_task_metadata;
DROP TABLE IF EXISTS tbl_task_categories;
DROP TABLE IF EXISTS tbl_notifications;
DROP TABLE IF EXISTS tbl_reminders;
DROP TABLE IF EXISTS tbl_file_uploads;
DROP TABLE IF EXISTS tbl_user_themes;
DROP TABLE IF EXISTS tbl_themes;
DROP TABLE IF EXISTS tbl_backup_logs;
DROP TABLE IF EXISTS tbl_audit_logs;
DROP TABLE IF EXISTS tbl_user_sessions;
DROP TABLE IF EXISTS tbl_daily_stats;
DROP TABLE IF EXISTS tbl_system_settings;
DROP TABLE IF EXISTS tbl_user_stats;
DROP TABLE IF EXISTS tbl_users;
DROP TABLE IF EXISTS tbl_schema_versions;

-- Drop stored procedures
DROP PROCEDURE IF EXISTS UpdateUserStats;
DROP PROCEDURE IF EXISTS CheckLevelUp;
DROP PROCEDURE IF EXISTS UpdateHabitStreak;
DROP PROCEDURE IF EXISTS CleanupOldData;
DROP PROCEDURE IF EXISTS UpdateLeaderboards;
DROP PROCEDURE IF EXISTS CheckUserAchievements;
DROP PROCEDURE IF EXISTS GenerateDailyStats;

-- Drop events
DROP EVENT IF EXISTS ev_daily_cleanup;
DROP EVENT IF EXISTS ev_daily_stats_generation;
DROP EVENT IF EXISTS ev_weekly_leaderboard_update;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Users table - Core user management
CREATE TABLE tbl_users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    auth_key VARCHAR(32) DEFAULT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    avatar_url VARCHAR(500),
    timezone VARCHAR(50) DEFAULT 'UTC',
    level INT UNSIGNED DEFAULT 1,
    total_xp BIGINT UNSIGNED DEFAULT 0,
    current_xp INT UNSIGNED DEFAULT 0,
    xp_to_next_level INT UNSIGNED DEFAULT 100,
    coins INT UNSIGNED DEFAULT 0,
    gems INT UNSIGNED DEFAULT 0,
    last_login_at TIMESTAMP NULL,
    email_verified_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_level (level),
    INDEX idx_active_users (is_active, last_login_at)
);

-- Player stats tracking
CREATE TABLE tbl_user_stats (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    physical_health INT UNSIGNED DEFAULT 0,
    creativity INT UNSIGNED DEFAULT 0,
    knowledge INT UNSIGNED DEFAULT 0,
    happiness INT UNSIGNED DEFAULT 0,
    money INT UNSIGNED DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_user_stats (user_id),
    INDEX idx_user_stats (user_id),
    INDEX idx_stats_health (physical_health),
    INDEX idx_stats_created (created_at)
);

-- =============================================================================
-- REMINDER MODULE
-- =============================================================================

-- User reminders
CREATE TABLE tbl_reminders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    reminder_type ENUM('habit', 'task', 'goal', 'custom') NOT NULL,
    related_id BIGINT UNSIGNED COMMENT 'ID of related habit/task/goal',
    title VARCHAR(255) NOT NULL,
    message TEXT,
    reminder_time TIME NOT NULL,
    reminder_days JSON COMMENT 'Array of weekdays (0-6, Sunday=0)',
    timezone VARCHAR(50) DEFAULT 'UTC',
    is_active BOOLEAN DEFAULT TRUE,
    last_sent_at TIMESTAMP NULL,
    next_send_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_reminders (user_id, is_active),
    INDEX idx_reminder_schedule (next_send_at, is_active),
    INDEX idx_reminder_type (reminder_type, related_id)
);

-- =============================================================================
-- ANALYTICS & TRACKING MODULE
-- =============================================================================

-- Daily user statistics snapshot
CREATE TABLE tbl_daily_stats (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    stat_date DATE NOT NULL,
    
    -- Daily activity counts
    tasks_completed INT UNSIGNED DEFAULT 0,
    habits_completed INT UNSIGNED DEFAULT 0,
    quests_progress INT UNSIGNED DEFAULT 0,
    journal_entries INT UNSIGNED DEFAULT 0,
    
    -- XP and level tracking
    xp_gained INT UNSIGNED DEFAULT 0,
    level_at_end_of_day INT UNSIGNED DEFAULT 1,
    
    -- Stat values at end of day
    physical_health INT UNSIGNED DEFAULT 0,
    creativity INT UNSIGNED DEFAULT 0,
    knowledge INT UNSIGNED DEFAULT 0,
    happiness INT UNSIGNED DEFAULT 0,
    money INT UNSIGNED DEFAULT 0,
    
    -- Streaks
    active_streaks INT UNSIGNED DEFAULT 0,
    longest_streak_today INT UNSIGNED DEFAULT 0,
    
    -- Social metrics
    social_interactions INT UNSIGNED DEFAULT 0,
    achievements_earned INT UNSIGNED DEFAULT 0,
    
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_user_date (user_id, stat_date),
    INDEX idx_daily_stats (user_id, stat_date),
    INDEX idx_stat_trends (stat_date, xp_gained)
);

-- User activity sessions
CREATE TABLE tbl_user_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    session_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_end TIMESTAMP NULL,
    duration_minutes INT UNSIGNED,
    activities_count INT UNSIGNED DEFAULT 0,
    pages_visited JSON COMMENT 'Array of page visits',
    device_info VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_sessions (user_id, session_start),
    INDEX idx_session_duration (duration_minutes),
    INDEX idx_active_sessions (session_end)
);

-- =============================================================================
-- BACKUP & AUDIT MODULE
-- =============================================================================

-- Audit trail for important changes
CREATE TABLE tbl_audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    table_name VARCHAR(100) NOT NULL,
    record_id BIGINT UNSIGNED NOT NULL,
    action ENUM('CREATE', 'UPDATE', 'DELETE') NOT NULL,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_audit_user (user_id, created_at),
    INDEX idx_audit_table (table_name, record_id),
    INDEX idx_audit_action (action, created_at)
);

-- System backup logs
CREATE TABLE tbl_backup_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    backup_type ENUM('full', 'incremental', 'differential') NOT NULL,
    backup_status ENUM('started', 'completed', 'failed') NOT NULL,
    file_path VARCHAR(500),
    file_size BIGINT UNSIGNED,
    backup_duration_seconds INT UNSIGNED,
    error_message TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_backup_status (backup_status, created_at),
    INDEX idx_backup_type (backup_type, created_at)
);

-- =============================================================================
-- UTILITY TABLES
-- =============================================================================

-- Application themes
CREATE TABLE tbl_themes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    description TEXT,
    css_variables JSON COMMENT 'Theme color variables',
    is_premium BOOLEAN DEFAULT FALSE,
    price_coins INT UNSIGNED DEFAULT 0,
    price_gems INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    preview_image_url VARCHAR(500),
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_theme_name (name),
    INDEX idx_theme_active (is_active),
    INDEX idx_premium_themes (is_premium, is_active)
);

-- User theme preferences
CREATE TABLE tbl_user_themes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    theme_id BIGINT UNSIGNED NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    dark_mode_enabled BOOLEAN DEFAULT FALSE,
    custom_settings JSON COMMENT 'User customizations',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (theme_id) REFERENCES tbl_themes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_themes (user_id, is_active),
    INDEX idx_active_user_theme (user_id, is_active)
);

-- File uploads/attachments
CREATE TABLE tbl_file_uploads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    stored_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size BIGINT UNSIGNED NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_hash VARCHAR(64) COMMENT 'SHA256 hash for deduplication',
    
    -- Relationship to other entities
    related_table VARCHAR(100) COMMENT 'Table this file belongs to',
    related_id BIGINT UNSIGNED COMMENT 'ID of the related record',
    
    is_public BOOLEAN DEFAULT FALSE,
    is_temporary BOOLEAN DEFAULT FALSE,
    expires_at TIMESTAMP NULL,
    download_count INT UNSIGNED DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_files (user_id, created_at),
    INDEX idx_file_hash (file_hash),
    INDEX idx_related_files (related_table, related_id),
    INDEX idx_temporary_files (is_temporary, expires_at)
);

-- System settings and configurations
CREATE TABLE tbl_system_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    INDEX idx_setting_key (setting_key),
    INDEX idx_public_settings (is_public)
);

-- =============================================================================
-- TASK MANAGEMENT MODULE
-- =============================================================================

-- Task categories
CREATE TABLE tbl_task_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    color_code VARCHAR(7) DEFAULT '#3b82f6',
    icon VARCHAR(50) DEFAULT 'fas fa-tasks',
    is_system_default BOOLEAN DEFAULT FALSE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    INDEX idx_category_name (name),
    INDEX idx_system_categories (is_system_default)
);

-- Main tasks metadata
CREATE TABLE tbl_task_metadata (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    due_date DATE,
    estimated_duration INT UNSIGNED COMMENT 'Duration in minutes',
    actual_duration INT UNSIGNED COMMENT 'Actual time spent in minutes',
    
    -- Stat rewards for completion
    health_reward TINYINT UNSIGNED DEFAULT 0,
    creativity_reward TINYINT UNSIGNED DEFAULT 0,
    knowledge_reward TINYINT UNSIGNED DEFAULT 0,
    happiness_reward TINYINT UNSIGNED DEFAULT 0,
    money_reward TINYINT UNSIGNED DEFAULT 0,
    xp_reward INT UNSIGNED DEFAULT 10,
    
    completed_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES tbl_task_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_tasks (user_id, status),
    INDEX idx_task_status (status),
    INDEX idx_task_priority (priority),
    INDEX idx_due_date (due_date),
    INDEX idx_completed_tasks (completed_at)
);

-- Task activity logs
CREATE TABLE tbl_task_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id BIGINT UNSIGNED NOT NULL,
    action ENUM('created', 'started', 'paused', 'resumed', 'completed', 'cancelled', 'updated') NOT NULL,
    old_status ENUM('pending', 'in_progress', 'completed', 'cancelled'),
    new_status ENUM('pending', 'in_progress', 'completed', 'cancelled'),
    notes TEXT,
    time_spent INT UNSIGNED COMMENT 'Time spent in this session (minutes)',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (task_id) REFERENCES tbl_task_metadata(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_task_logs (task_id, created_at),
    INDEX idx_task_actions (action, created_at)
);

-- =============================================================================
-- QUEST SYSTEM MODULE
-- =============================================================================

-- Quest templates (reusable quest definitions)
CREATE TABLE tbl_quest_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    quest_type ENUM('daily', 'weekly', 'monthly', 'custom', 'epic') DEFAULT 'custom',
    difficulty ENUM('easy', 'medium', 'hard', 'legendary') DEFAULT 'medium',
    duration_days INT UNSIGNED DEFAULT 30,
    icon VARCHAR(50) DEFAULT 'fas fa-scroll',
    
    -- Rewards
    health_reward TINYINT UNSIGNED DEFAULT 0,
    creativity_reward TINYINT UNSIGNED DEFAULT 0,
    knowledge_reward TINYINT UNSIGNED DEFAULT 0,
    happiness_reward TINYINT UNSIGNED DEFAULT 0,
    money_reward TINYINT UNSIGNED DEFAULT 0,
    xp_reward INT UNSIGNED DEFAULT 100,
    coins_reward INT UNSIGNED DEFAULT 0,
    gems_reward INT UNSIGNED DEFAULT 0,
    
    is_system_quest BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    INDEX idx_quest_type (quest_type),
    INDEX idx_quest_difficulty (difficulty),
    INDEX idx_system_quests (is_system_quest, is_active)
);

-- User's active/completed quests
CREATE TABLE tbl_user_quests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    quest_template_id BIGINT UNSIGNED,
    custom_name VARCHAR(255),
    custom_description TEXT,
    status ENUM('available', 'active', 'completed', 'failed', 'abandoned') DEFAULT 'available',
    progress_current INT UNSIGNED DEFAULT 0,
    progress_target INT UNSIGNED NOT NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    
    -- Override rewards if custom quest
    health_reward TINYINT UNSIGNED DEFAULT 0,
    creativity_reward TINYINT UNSIGNED DEFAULT 0,
    knowledge_reward TINYINT UNSIGNED DEFAULT 0,
    happiness_reward TINYINT UNSIGNED DEFAULT 0,
    money_reward TINYINT UNSIGNED DEFAULT 0,
    xp_reward INT UNSIGNED DEFAULT 100,
    coins_reward INT UNSIGNED DEFAULT 0,
    gems_reward INT UNSIGNED DEFAULT 0,
    
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (quest_template_id) REFERENCES tbl_quest_templates(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_quests (user_id, status),
    INDEX idx_active_quests (status, started_at),
    INDEX idx_quest_expiry (expires_at)
);

-- Quest progress tracking
CREATE TABLE tbl_quest_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_quest_id BIGINT UNSIGNED NOT NULL,
    progress_increment INT UNSIGNED DEFAULT 1,
    notes TEXT,
    related_task_id BIGINT UNSIGNED NULL,
    related_habit_id BIGINT UNSIGNED NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_quest_id) REFERENCES tbl_user_quests(id) ON DELETE CASCADE,
    FOREIGN KEY (related_task_id) REFERENCES tbl_task_metadata(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_quest_progress (user_quest_id, created_at),
    INDEX idx_related_tasks (related_task_id),
    INDEX idx_related_habits (related_habit_id)
);

-- =============================================================================
-- HABIT TRACKING MODULE
-- =============================================================================

-- Habit metadata (habit definitions)
CREATE TABLE tbl_habit_metadata (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    planned_frequency ENUM('daily', 'weekly', 'custom') DEFAULT 'daily',
    frequency_value INT UNSIGNED DEFAULT 1 COMMENT 'How many times per frequency period',
    reminder_time TIME NULL,
    reminder_enabled BOOLEAN DEFAULT TRUE,
    color_code VARCHAR(7) DEFAULT '#10b981',
    icon VARCHAR(50) DEFAULT 'fas fa-check-circle',
    
    -- Stat updates per completion
    health_update TINYINT SIGNED DEFAULT 0,
    creativity_update TINYINT SIGNED DEFAULT 0,
    knowledge_update TINYINT SIGNED DEFAULT 0,
    happiness_update TINYINT SIGNED DEFAULT 0,
    money_update TINYINT SIGNED DEFAULT 0,
    xp_reward INT UNSIGNED DEFAULT 5,
    
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_habits (user_id, is_active),
    INDEX idx_habit_frequency (planned_frequency),
    INDEX idx_reminder_time (reminder_time, reminder_enabled)
);

-- Habit completion logs
CREATE TABLE tbl_habit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    habit_id BIGINT UNSIGNED NOT NULL,
    log_date DATE NOT NULL,
    log_time TIME NOT NULL,
    completion_status ENUM('completed', 'partial', 'skipped') DEFAULT 'completed',
    notes TEXT,
    mood_rating TINYINT UNSIGNED COMMENT 'Optional mood rating 1-5',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (habit_id) REFERENCES tbl_habit_metadata(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_habit_date (habit_id, log_date),
    INDEX idx_habit_logs_date (habit_id, log_date),
    INDEX idx_completion_status (completion_status, log_date)
);

-- Habit streak tracking
CREATE TABLE tbl_habit_streaks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    habit_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    current_streak INT UNSIGNED DEFAULT 0,
    longest_streak INT UNSIGNED DEFAULT 0,
    last_completion_date DATE,
    streak_start_date DATE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (habit_id) REFERENCES tbl_habit_metadata(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_habit_streak (habit_id, user_id),
    INDEX idx_user_streaks (user_id, current_streak),
    INDEX idx_longest_streaks (longest_streak)
);

-- =============================================================================
-- ACHIEVEMENT SYSTEM MODULE
-- =============================================================================

-- Achievement definitions
CREATE TABLE tbl_achievement_metadata (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('tasks', 'habits', 'quests', 'social', 'stats', 'streaks', 'special') DEFAULT 'tasks',
    rarity ENUM('common', 'rare', 'epic', 'legendary') DEFAULT 'common',
    icon VARCHAR(50) DEFAULT 'fas fa-trophy',
    badge_color VARCHAR(7) DEFAULT '#fbbf24',
    
    -- Unlock conditions (stored as JSON for flexibility)
    unlock_conditions JSON,
    
    -- Rewards
    xp_reward INT UNSIGNED DEFAULT 50,
    coins_reward INT UNSIGNED DEFAULT 0,
    gems_reward INT UNSIGNED DEFAULT 0,
    title_unlock VARCHAR(100),
    
    is_system_achievement BOOLEAN DEFAULT TRUE,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    INDEX idx_achievement_category (category),
    INDEX idx_achievement_rarity (rarity),
    INDEX idx_system_achievements (is_system_achievement, is_active)
);

-- User achievements
CREATE TABLE tbl_user_achievements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    achievement_id BIGINT UNSIGNED NOT NULL,
    progress_current INT UNSIGNED DEFAULT 0,
    progress_target INT UNSIGNED DEFAULT 1,
    is_completed BOOLEAN DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    is_showcased BOOLEAN DEFAULT FALSE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (achievement_id) REFERENCES tbl_achievement_metadata(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_user_achievement (user_id, achievement_id),
    INDEX idx_user_achievements (user_id, is_completed),
    INDEX idx_completed_achievements (completed_at),
    INDEX idx_showcased_achievements (is_showcased)
);

-- =============================================================================
-- GOAL SETTING MODULE
-- =============================================================================

-- Goal metadata
CREATE TABLE tbl_goal_metadata (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    goal_type ENUM('health', 'learning', 'career', 'personal', 'financial', 'creative') DEFAULT 'personal',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('active', 'completed', 'paused', 'cancelled') DEFAULT 'active',
    target_date DATE,
    progress_type ENUM('boolean', 'numeric', 'checklist') DEFAULT 'boolean',
    progress_current DECIMAL(10,2) DEFAULT 0,
    progress_target DECIMAL(10,2) DEFAULT 1,
    progress_unit VARCHAR(50),
    
    -- Rewards for completion
    health_reward TINYINT UNSIGNED DEFAULT 0,
    creativity_reward TINYINT UNSIGNED DEFAULT 0,
    knowledge_reward TINYINT UNSIGNED DEFAULT 0,
    happiness_reward TINYINT UNSIGNED DEFAULT 0,
    money_reward TINYINT UNSIGNED DEFAULT 0,
    xp_reward INT UNSIGNED DEFAULT 100,
    
    completed_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_goals (user_id, status),
    INDEX idx_goal_type (goal_type),
    INDEX idx_target_date (target_date),
    INDEX idx_completed_goals (completed_at)
);

-- Goal milestones/sub-goals
CREATE TABLE tbl_goal_milestones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    goal_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    target_date DATE,
    is_completed BOOLEAN DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    sort_order INT UNSIGNED DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (goal_id) REFERENCES tbl_goal_metadata(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_goal_milestones (goal_id, sort_order),
    INDEX idx_milestone_completion (is_completed, completed_at)
);

-- Goal progress logs
CREATE TABLE tbl_goal_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    goal_id BIGINT UNSIGNED NOT NULL,
    progress_increment DECIMAL(10,2) DEFAULT 0,
    notes TEXT,
    related_task_id BIGINT UNSIGNED NULL,
    related_habit_id BIGINT UNSIGNED NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (goal_id) REFERENCES tbl_goal_metadata(id) ON DELETE CASCADE,
    FOREIGN KEY (related_task_id) REFERENCES tbl_task_metadata(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_goal_progress (goal_id, created_at),
    INDEX idx_related_tasks (related_task_id),
    INDEX idx_related_habits (related_habit_id)
);

-- =============================================================================
-- JOURNAL MODULE
-- =============================================================================

-- Journal entries
CREATE TABLE tbl_journal_entries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    entry_date DATE NOT NULL,
    mood ENUM('very_happy', 'happy', 'neutral', 'sad', 'very_sad') DEFAULT 'neutral',
    mood_emoji VARCHAR(10),
    title VARCHAR(255),
    content_positive TEXT COMMENT 'What went well',
    content_negative TEXT COMMENT 'What could be improved',
    content_tomorrow TEXT COMMENT 'Tomorrows focus',
    content_general TEXT COMMENT 'General thoughts',
    is_private BOOLEAN DEFAULT TRUE,
    tags JSON COMMENT 'Array of tags for categorization',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_user_date (user_id, entry_date),
    INDEX idx_journal_entries (user_id, entry_date),
    INDEX idx_mood_tracking (mood, entry_date)
);

-- =============================================================================
-- LEADERBOARD MODULE
-- =============================================================================

-- Leaderboard periods
CREATE TABLE tbl_leaderboard_periods (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    period_type ENUM('daily', 'weekly', 'monthly', 'yearly', 'all_time') NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    is_current BOOLEAN DEFAULT FALSE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    INDEX idx_leaderboard_periods (period_type, is_current),
    INDEX idx_current_periods (is_current, period_start)
);

-- Leaderboard entries
CREATE TABLE tbl_leaderboard_entries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    period_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    rank_position INT UNSIGNED NOT NULL,
    total_xp BIGINT UNSIGNED DEFAULT 0,
    tasks_completed INT UNSIGNED DEFAULT 0,
    habits_completed INT UNSIGNED DEFAULT 0,
    quests_completed INT UNSIGNED DEFAULT 0,
    achievements_earned INT UNSIGNED DEFAULT 0,
    streak_days INT UNSIGNED DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (period_id) REFERENCES tbl_leaderboard_periods(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_period_user (period_id, user_id),
    INDEX idx_leaderboard_rank (period_id, rank_position),
    INDEX idx_user_rankings (user_id, period_id)
);

-- =============================================================================
-- SHOP MODULE
-- =============================================================================

-- Shop items
CREATE TABLE tbl_shop_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    item_type ENUM('powerup', 'theme', 'reward', 'premium', 'consumable') DEFAULT 'powerup',
    category VARCHAR(100),
    icon VARCHAR(50) DEFAULT 'fas fa-shopping-cart',
    price_coins INT UNSIGNED DEFAULT 0,
    price_gems INT UNSIGNED DEFAULT 0,
    rarity ENUM('common', 'rare', 'epic', 'legendary') DEFAULT 'common',
    
    -- Item effects (stored as JSON for flexibility)
    item_effects JSON,
    duration_hours INT UNSIGNED COMMENT 'For temporary items',
    
    is_active BOOLEAN DEFAULT TRUE,
    is_limited_time BOOLEAN DEFAULT FALSE,
    available_from TIMESTAMP NULL,
    available_until TIMESTAMP NULL,
    max_purchases_per_user INT UNSIGNED,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    INDEX idx_shop_items (item_type, is_active),
    INDEX idx_item_availability (is_active, available_from, available_until),
    INDEX idx_limited_items (is_limited_time, available_until)
);

-- User purchases
CREATE TABLE tbl_user_purchases (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    shop_item_id BIGINT UNSIGNED NOT NULL,
    purchase_price_coins INT UNSIGNED DEFAULT 0,
    purchase_price_gems INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    expires_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (shop_item_id) REFERENCES tbl_shop_items(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_purchases (user_id, is_active),
    INDEX idx_purchase_expiry (expires_at, is_active)
);

-- =============================================================================
-- SOCIAL MODULE
-- =============================================================================

-- User friendships
CREATE TABLE tbl_user_friendships (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    requester_id BIGINT UNSIGNED NOT NULL,
    addressee_id BIGINT UNSIGNED NOT NULL,
    status ENUM('pending', 'accepted', 'declined', 'blocked') DEFAULT 'pending',
    accepted_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (requester_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (addressee_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_friendship (requester_id, addressee_id),
    INDEX idx_user_friends (requester_id, status),
    INDEX idx_pending_requests (status, created_at)
);

-- Social activity feed
CREATE TABLE tbl_social_activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    activity_type ENUM('task_completed', 'quest_completed', 'achievement_earned', 'level_up', 'streak_milestone', 'goal_completed') NOT NULL,
    activity_data JSON COMMENT 'Flexible data for different activity types',
    is_public BOOLEAN DEFAULT TRUE,
    likes_count INT UNSIGNED DEFAULT 0,
    comments_count INT UNSIGNED DEFAULT 0,
    shares_count INT UNSIGNED DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_social_activities (user_id, created_at),
    INDEX idx_public_activities (is_public, created_at),
    INDEX idx_activity_type (activity_type, created_at)
);

-- Social activity interactions (likes, comments, shares)
CREATE TABLE tbl_social_interactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    activity_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    interaction_type ENUM('like', 'comment', 'share') NOT NULL,
    comment_text TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (activity_id) REFERENCES tbl_social_activities(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    UNIQUE KEY unique_user_activity_type (activity_id, user_id, interaction_type),
    INDEX idx_activity_interactions (activity_id, interaction_type),
    INDEX idx_user_interactions (user_id, created_at)
);

-- =============================================================================
-- NOTIFICATION MODULE
-- =============================================================================

-- Notifications
CREATE TABLE tbl_notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type ENUM('reminder', 'achievement', 'social', 'system', 'quest', 'friend_request') NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT,
    data JSON COMMENT 'Additional notification data',
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES tbl_users(id),
    
    INDEX idx_user_notifications (user_id, is_read),
    INDEX idx_notification_type (type, created_at),
    INDEX idx_unread_notifications (is_read, created_at),
    INDEX idx_notification_expiry (expires_at)
);


-- =============================================================================
-- INITIAL DATA INSERTS
-- =============================================================================
SET FOREIGN_KEY_CHECKS = 0;

-- Create system user first
INSERT INTO tbl_users (id, username, email, password_hash, auth_key, first_name, last_name, is_active) 
VALUES (1, 'system', 'system@lifequest.app', '$2y$10$systemhash', 'sys_auth_key_123456789012', 'System', 'User', TRUE);

-- Create system user stats
INSERT INTO tbl_user_stats (user_id, created_by) VALUES (1, 1);

-- Insert default system settings
INSERT INTO tbl_system_settings (setting_key, setting_value, setting_type, description, is_public, created_by) VALUES
('app_name', 'Life Quest', 'string', 'Application name', TRUE, 1),
('app_version', '1.0.0', 'string', 'Current application version', TRUE, 1),
('default_xp_per_task', '10', 'integer', 'Default XP reward for task completion', FALSE, 1),
('default_xp_per_habit', '5', 'integer', 'Default XP reward for habit completion', FALSE, 1),
('level_xp_multiplier', '1.2', 'string', 'XP multiplier for each level', FALSE, 1),
('max_level', '100', 'integer', 'Maximum user level', FALSE, 1),
('streak_bonus_multiplier', '0.1', 'string', 'Bonus XP multiplier for streaks', FALSE, 1);

-- Insert default task categories
INSERT INTO tbl_task_categories (name, description, color_code, icon, is_system_default, created_by) VALUES
('Health & Fitness', 'Physical health and exercise related tasks', '#ef4444', 'fas fa-heart', TRUE, 1),
('Learning & Growth', 'Educational and skill development tasks', '#3b82f6', 'fas fa-brain', TRUE, 1),
('Creative Projects', 'Art, writing, and creative endeavors', '#8b5cf6', 'fas fa-palette', TRUE, 1),
('Work & Career', 'Professional and career development tasks', '#059669', 'fas fa-briefcase', TRUE, 1),
('Social & Relationships', 'Social activities and relationship building', '#f59e0b', 'fas fa-users', TRUE, 1),
('Personal Care', 'Self-care and wellness activities', '#ec4899', 'fas fa-spa', TRUE, 1);

-- Insert default themes
INSERT INTO tbl_themes (name, display_name, description, css_variables, is_premium, price_coins, price_gems, is_active, created_by) VALUES
('default_light', 'Default Light', 'Clean and bright default theme', '{"primary": "#3b82f6", "secondary": "#64748b", "accent": "#10b981"}', FALSE, 0, 0, TRUE, 1),
('default_dark', 'Default Dark', 'Dark mode for comfortable night usage', '{"primary": "#3b82f6", "bg_primary": "#0f172a", "bg_secondary": "#1e293b"}', FALSE, 0, 0, TRUE, 1),
('ocean_blue', 'Ocean Blue', 'Calming blue ocean inspired theme', '{"primary": "#0ea5e9", "secondary": "#0284c7", "accent": "#06b6d4"}', TRUE, 300, 0, TRUE, 1),
('forest_green', 'Forest Green', 'Nature inspired green theme', '{"primary": "#059669", "secondary": "#047857", "accent": "#10b981"}', TRUE, 300, 0, TRUE, 1);

-- Insert sample quest templates
INSERT INTO tbl_quest_templates (name, description, quest_type, difficulty, duration_days, icon, health_reward, creativity_reward, knowledge_reward, happiness_reward, money_reward, xp_reward, coins_reward, is_system_quest, created_by) VALUES
('Fitness Warrior', 'Complete 30 days of consistent exercise to unlock massive health gains', 'custom', 'medium', 30, 'fas fa-dumbbell', 25, 0, 0, 10, 0, 500, 100, TRUE, 1),
('Knowledge Seeker', 'Read 10 books this quarter to expand your mind', 'custom', 'hard', 90, 'fas fa-book', 0, 5, 30, 15, 0, 750, 150, TRUE, 1),
('Creative Master', 'Complete 15 creative projects in 30 days', 'custom', 'medium', 30, 'fas fa-paint-brush', 0, 30, 5, 20, 0, 600, 120, TRUE, 1),
('Zen Master', 'Meditate daily for 21 days straight', 'custom', 'easy', 21, 'fas fa-lotus-position', 10, 0, 0, 25, 0, 350, 70, TRUE, 1),
('Wealth Builder', 'Save $1000 and track expenses for 60 days', 'custom', 'hard', 60, 'fas fa-piggy-bank', 0, 0, 10, 15, 25, 800, 200, TRUE, 1);

-- Insert sample achievements
INSERT INTO tbl_achievement_metadata (name, description, category, rarity, icon, badge_color, unlock_conditions, xp_reward, coins_reward, gems_reward, is_system_achievement, created_by) VALUES
('First Steps', 'Complete your first task', 'tasks', 'common', 'fas fa-baby-carriage', '#22c55e', '{"tasks_completed": 1}', 50, 10, 0, TRUE, 1),
('Task Master', 'Complete 100 tasks', 'tasks', 'rare', 'fas fa-tasks', '#3b82f6', '{"tasks_completed": 100}', 200, 50, 1, TRUE, 1),
('Legendary Achiever', 'Complete 1000 tasks', 'tasks', 'legendary', 'fas fa-crown', '#fbbf24', '{"tasks_completed": 1000}', 1000, 200, 5, TRUE, 1),
('Streak Starter', 'Maintain a 7-day streak', 'streaks', 'common', 'fas fa-fire', '#f59e0b', '{"streak_days": 7}', 100, 20, 0, TRUE, 1),
('Streak Warrior', 'Maintain a 30-day streak', 'streaks', 'epic', 'fas fa-fire-flame-curved', '#ef4444', '{"streak_days": 30}', 300, 75, 2, TRUE, 1),
('Social Butterfly', 'Make 10 friends', 'social', 'rare', 'fas fa-users', '#8b5cf6', '{"friends_count": 10}', 150, 30, 1, TRUE, 1),
('Knowledge Seeker', 'Gain 500 knowledge points', 'stats', 'rare', 'fas fa-brain', '#3b82f6', '{"knowledge_total": 500}', 250, 50, 1, TRUE, 1),
('Health Enthusiast', 'Gain 500 health points', 'stats', 'rare', 'fas fa-heart', '#ef4444', '{"health_total": 500}', 250, 50, 1, TRUE, 1);

-- Insert sample shop items
INSERT INTO tbl_shop_items (name, description, item_type, category, icon, price_coins, price_gems, rarity, item_effects, duration_hours, is_active, created_by) VALUES
('XP Booster', 'Double XP for the next 24 hours', 'powerup', 'Boosters', 'fas fa-bolt', 150, 0, 'common', '{"xp_multiplier": 2.0}', 24, TRUE, 1),
('Stat Multiplier', '1.5x stat gains for 3 days', 'powerup', 'Boosters', 'fas fa-chart-line', 0, 5, 'rare', '{"stat_multiplier": 1.5}', 72, TRUE, 1),
('Streak Freeze', 'Protect your streak for one missed day', 'consumable', 'Utilities', 'fas fa-shield-alt', 100, 0, 'common', '{"streak_protection": 1}', NULL, TRUE, 1),
('Dark Knight Theme', 'Sleek dark theme with blue accents', 'theme', 'Themes', 'fas fa-moon', 300, 0, 'rare', '{"theme_id": "dark_knight"}', NULL, TRUE, 1),
('Cherry Blossom Theme', 'Beautiful pink and white theme', 'theme', 'Themes', 'fas fa-cherry', 250, 0, 'rare', '{"theme_id": "cherry_blossom"}', NULL, TRUE, 1),
('Coffee Treat', 'Reward yourself with your favorite coffee', 'reward', 'Real Rewards', 'fas fa-coffee', 200, 0, 'common', '{"reward_type": "coffee_voucher"}', NULL, TRUE, 1),
('Movie Night', 'Enjoy a movie of your choice', 'reward', 'Real Rewards', 'fas fa-film', 300, 0, 'common', '{"reward_type": "movie_voucher"}', NULL, TRUE, 1);


-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;
-- =============================================================================
-- PERFORMANCE OPTIMIZATION INDEXES
-- =============================================================================

-- Additional composite indexes for common query patterns
CREATE INDEX idx_task_user_status_due ON tbl_task_metadata(user_id, status, due_date);
CREATE INDEX idx_habit_user_active_reminder ON tbl_habit_metadata(user_id, is_active, reminder_time);
CREATE INDEX idx_quest_user_status_progress ON tbl_user_quests(user_id, status, progress_current);
CREATE INDEX idx_achievement_user_completed ON tbl_user_achievements(user_id, is_completed, completed_at);
CREATE INDEX idx_goal_user_active_target ON tbl_goal_metadata(user_id, status, target_date);
CREATE INDEX idx_journal_user_date_mood ON tbl_journal_entries(user_id, entry_date, mood);
CREATE INDEX idx_notification_user_unread ON tbl_notifications(user_id, is_read, priority);
CREATE INDEX idx_social_activity_public_recent ON tbl_social_activities(is_public, created_at);
CREATE INDEX idx_leaderboard_period_rank ON tbl_leaderboard_entries(period_id, rank_position);
CREATE INDEX idx_daily_stats_date_xp ON tbl_daily_stats(stat_date, xp_gained);

-- =============================================================================
-- STORED PROCEDURES FOR COMMON OPERATIONS
-- =============================================================================

DELIMITER //

-- Procedure to update user stats after task/habit completion
CREATE PROCEDURE UpdateUserStats(
    IN p_user_id BIGINT UNSIGNED,
    IN p_health_change TINYINT SIGNED,
    IN p_creativity_change TINYINT SIGNED,
    IN p_knowledge_change TINYINT SIGNED,
    IN p_happiness_change TINYINT SIGNED,
    IN p_money_change TINYINT SIGNED,
    IN p_xp_change INT UNSIGNED,
    IN p_updated_by BIGINT UNSIGNED
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Update user stats
    UPDATE tbl_user_stats 
    SET physical_health = GREATEST(0, LEAST(100, physical_health + p_health_change)),
        creativity = GREATEST(0, LEAST(100, creativity + p_creativity_change)),
        knowledge = GREATEST(0, LEAST(100, knowledge + p_knowledge_change)),
        happiness = GREATEST(0, LEAST(100, happiness + p_happiness_change)),
        money = GREATEST(0, LEAST(100, money + p_money_change)),
        updated_at = CURRENT_TIMESTAMP
    WHERE user_id = p_user_id;
    
    -- Update user XP and potentially level
    UPDATE tbl_users 
    SET total_xp = total_xp + p_xp_change,
        current_xp = current_xp + p_xp_change,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_user_id;
    
    -- Check for level up
    CALL CheckLevelUp(p_user_id);
    
    COMMIT;
END //

-- Procedure to check and handle level ups
CREATE PROCEDURE CheckLevelUp(IN p_user_id BIGINT UNSIGNED)
BEGIN
    DECLARE v_current_level INT UNSIGNED;
    DECLARE v_current_xp INT UNSIGNED;
    DECLARE v_xp_to_next INT UNSIGNED;
    DECLARE v_new_level INT UNSIGNED;
    
    SELECT level, current_xp, xp_to_next_level 
    INTO v_current_level, v_current_xp, v_xp_to_next
    FROM tbl_users 
    WHERE id = p_user_id;
    
    WHILE v_current_xp >= v_xp_to_next DO
        SET v_new_level = v_current_level + 1;
        SET v_current_xp = v_current_xp - v_xp_to_next;
        SET v_xp_to_next = FLOOR(v_xp_to_next * 1.2); -- 20% increase per level
        SET v_current_level = v_new_level;
    END WHILE;
    
    -- Update user level if changed
    IF v_current_level > (SELECT level FROM tbl_users WHERE id = p_user_id) THEN
        UPDATE tbl_users 
        SET level = v_current_level,
            current_xp = v_current_xp,
            xp_to_next_level = v_xp_to_next,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = p_user_id;
        
        -- Create level up notification
        INSERT INTO tbl_notifications (user_id, type, title, message, created_by)
        VALUES (p_user_id, 'system', 'Level Up!', 
                CONCAT('Congratulations! You reached level ', v_current_level, '!'), 
                p_user_id);
    END IF;
END //

-- Procedure to update habit streaks
CREATE PROCEDURE UpdateHabitStreak(
    IN p_habit_id BIGINT UNSIGNED,
    IN p_user_id BIGINT UNSIGNED,
    IN p_completion_date DATE,
    IN p_updated_by BIGINT UNSIGNED
)
BEGIN
    DECLARE v_current_streak INT UNSIGNED DEFAULT 0;
    DECLARE v_longest_streak INT UNSIGNED DEFAULT 0;
    DECLARE v_last_completion DATE;
    DECLARE v_new_streak INT UNSIGNED;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Get current streak info
    SELECT current_streak, longest_streak, last_completion_date
    INTO v_current_streak, v_longest_streak, v_last_completion
    FROM tbl_habit_streaks
    WHERE habit_id = p_habit_id AND user_id = p_user_id;
    
    -- Calculate new streak
    IF v_last_completion IS NULL OR DATEDIFF(p_completion_date, v_last_completion) = 1 THEN
        SET v_new_streak = v_current_streak + 1;
    ELSEIF DATEDIFF(p_completion_date, v_last_completion) = 0 THEN
        SET v_new_streak = v_current_streak; -- Same day, no change
    ELSE
        SET v_new_streak = 1; -- Streak broken, restart
    END IF;
    
    -- Update streak record
    INSERT INTO tbl_habit_streaks (habit_id, user_id, current_streak, longest_streak, last_completion_date, streak_start_date, created_by)
    VALUES (p_habit_id, p_user_id, v_new_streak, GREATEST(v_longest_streak, v_new_streak), p_completion_date, 
            CASE WHEN v_new_streak = 1 THEN p_completion_date ELSE 
                (SELECT streak_start_date FROM tbl_habit_streaks WHERE habit_id = p_habit_id AND user_id = p_user_id) 
            END, p_updated_by)
    ON DUPLICATE KEY UPDATE
        current_streak = v_new_streak,
        longest_streak = GREATEST(longest_streak, v_new_streak),
        last_completion_date = p_completion_date,
        updated_at = CURRENT_TIMESTAMP;
    
    COMMIT;
END //

DELIMITER ;

-- =============================================================================
-- VIEWS FOR COMMON QUERIES
-- =============================================================================

-- User dashboard summary view
CREATE VIEW vw_user_dashboard AS
SELECT 
    u.id as user_id,
    u.username,
    u.level,
    u.total_xp,
    u.current_xp,
    u.xp_to_next_level,
    u.coins,
    u.gems,
    us.physical_health,
    us.creativity,
    us.knowledge,
    us.happiness,
    us.money,
    
    -- Task counts
    (SELECT COUNT(*) FROM tbl_task_metadata tm WHERE tm.user_id = u.id AND tm.status = 'pending') as pending_tasks,
    (SELECT COUNT(*) FROM tbl_task_metadata tm WHERE tm.user_id = u.id AND tm.status = 'completed' AND DATE(tm.completed_at) = CURDATE()) as tasks_completed_today,
    
    -- Habit streak info
    (SELECT MAX(hs.current_streak) FROM tbl_habit_streaks hs WHERE hs.user_id = u.id) as longest_current_streak,
    (SELECT COUNT(*) FROM tbl_habit_logs hl JOIN tbl_habit_metadata hm ON hl.habit_id = hm.id WHERE hm.user_id = u.id AND hl.log_date = CURDATE()) as habits_completed_today,
    
    -- Quest progress
    (SELECT COUNT(*) FROM tbl_user_quests uq WHERE uq.user_id = u.id AND uq.status = 'active') as active_quests,
    
    -- Recent achievements
    (SELECT COUNT(*) FROM tbl_user_achievements ua WHERE ua.user_id = u.id AND ua.is_completed = TRUE AND ua.completed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)) as achievements_this_week

FROM tbl_users u
LEFT JOIN tbl_user_stats us ON u.id = us.user_id
WHERE u.is_active = TRUE;

-- Leaderboard view
CREATE VIEW vw_weekly_leaderboard AS
SELECT 
    u.id as user_id,
    u.username,
    u.level,
    COALESCE(ds_week.total_xp, 0) as weekly_xp,
    COALESCE(ds_week.tasks_completed, 0) as weekly_tasks,
    COALESCE(ds_week.habits_completed, 0) as weekly_habits,
    ROW_NUMBER() OVER (ORDER BY COALESCE(ds_week.total_xp, 0) DESC) as rank_position
FROM tbl_users u
LEFT JOIN (
    SELECT 
        user_id,
        SUM(xp_gained) as total_xp,
        SUM(tasks_completed) as tasks_completed,
        SUM(habits_completed) as habits_completed
    FROM tbl_daily_stats 
    WHERE stat_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY user_id
) ds_week ON u.id = ds_week.user_id
WHERE u.is_active = TRUE
ORDER BY weekly_xp DESC;

-- =============================================================================
-- TRIGGERS FOR AUTOMATED OPERATIONS
-- =============================================================================

-- Trigger to create user stats record when user is created
DELIMITER //
CREATE TRIGGER tr_create_user_stats 
AFTER INSERT ON tbl_users
FOR EACH ROW
BEGIN
    INSERT INTO tbl_user_stats (user_id, created_by)
    VALUES (NEW.id, NEW.id);
END //
DELIMITER ;

-- Trigger to update daily stats when tasks are completed
DELIMITER //
CREATE TRIGGER tr_task_completion_stats
AFTER UPDATE ON tbl_task_metadata
FOR EACH ROW
BEGIN
    IF OLD.status != 'completed' AND NEW.status = 'completed' THEN
        INSERT INTO tbl_daily_stats (user_id, stat_date, tasks_completed, xp_gained, created_by)
        VALUES (NEW.user_id, CURDATE(), 1, NEW.xp_reward, NEW.created_by)
        ON DUPLICATE KEY UPDATE
            tasks_completed = tasks_completed + 1,
            xp_gained = xp_gained + NEW.xp_reward,
            updated_at = CURRENT_TIMESTAMP;
    END IF;
END //
DELIMITER ;

-- =============================================================================
-- DATABASE MAINTENANCE PROCEDURES
-- =============================================================================

DELIMITER //

-- Procedure to clean up old data
CREATE PROCEDURE CleanupOldData()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Clean up old audit logs (keep 1 year)
    DELETE FROM tbl_audit_logs 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 YEAR);
    
    -- Clean up old user sessions (keep 3 months)
    DELETE FROM tbl_user_sessions 
    WHERE session_start < DATE_SUB(NOW(), INTERVAL 3 MONTH);
    
    -- Clean up expired temporary files
    DELETE FROM tbl_file_uploads 
    WHERE is_temporary = TRUE AND expires_at < NOW();
    
    -- Clean up old notifications (keep 6 months)
    DELETE FROM tbl_notifications 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);
    
    -- Clean up expired shop purchases
    UPDATE tbl_user_purchases 
    SET is_active = FALSE 
    WHERE expires_at < NOW() AND is_active = TRUE;
    
    COMMIT;
END //

-- Procedure to update leaderboard rankings
CREATE PROCEDURE UpdateLeaderboards()
BEGIN
    DECLARE v_period_id BIGINT UNSIGNED;
    DECLARE v_period_start DATE;
    DECLARE v_period_end DATE;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Get or create current weekly period
    SELECT id, period_start, period_end INTO v_period_id, v_period_start, v_period_end
    FROM tbl_leaderboard_periods 
    WHERE period_type = 'weekly' AND is_current = TRUE
    LIMIT 1;
    
    IF v_period_id IS NULL THEN
        SET v_period_start = DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY);
        SET v_period_end = DATE_ADD(v_period_start, INTERVAL 6 DAY);
        
        INSERT INTO tbl_leaderboard_periods (period_type, period_start, period_end, is_current, created_by)
        VALUES ('weekly', v_period_start, v_period_end, TRUE, 1);
        
        SET v_period_id = LAST_INSERT_ID();
    END IF;
    
    -- Clear existing entries for this period
    DELETE FROM tbl_leaderboard_entries WHERE period_id = v_period_id;
    
    -- Calculate and insert new rankings
    INSERT INTO tbl_leaderboard_entries (
        period_id, user_id, rank_position, total_xp, tasks_completed, 
        habits_completed, quests_completed, achievements_earned, created_by
    )
    SELECT 
        v_period_id,
        u.id,
        ROW_NUMBER() OVER (ORDER BY COALESCE(weekly_stats.total_xp, 0) DESC),
        COALESCE(weekly_stats.total_xp, 0),
        COALESCE(weekly_stats.tasks_completed, 0),
        COALESCE(weekly_stats.habits_completed, 0),
        COALESCE(weekly_stats.quests_completed, 0),
        COALESCE(weekly_stats.achievements_earned, 0),
        1
    FROM tbl_users u
    LEFT JOIN (
        SELECT 
            user_id,
            SUM(xp_gained) as total_xp,
            SUM(tasks_completed) as tasks_completed,
            SUM(habits_completed) as habits_completed,
            SUM(quests_progress) as quests_completed,
            SUM(achievements_earned) as achievements_earned
        FROM tbl_daily_stats 
        WHERE stat_date BETWEEN v_period_start AND v_period_end
        GROUP BY user_id
    ) weekly_stats ON u.id = weekly_stats.user_id
    WHERE u.is_active = TRUE
    ORDER BY COALESCE(weekly_stats.total_xp, 0) DESC;
    
    COMMIT;
END //

-- Procedure to check and award achievements
CREATE PROCEDURE CheckUserAchievements(IN p_user_id BIGINT UNSIGNED)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_achievement_id BIGINT UNSIGNED;
    DECLARE v_unlock_conditions JSON;
    DECLARE v_xp_reward INT UNSIGNED;
    DECLARE v_coins_reward INT UNSIGNED;
    DECLARE v_gems_reward INT UNSIGNED;
    
    -- Cursor for unearned achievements
    DECLARE achievement_cursor CURSOR FOR
        SELECT am.id, am.unlock_conditions, am.xp_reward, am.coins_reward, am.gems_reward
        FROM tbl_achievement_metadata am
        LEFT JOIN tbl_user_achievements ua ON am.id = ua.achievement_id AND ua.user_id = p_user_id
        WHERE am.is_active = TRUE 
        AND am.is_system_achievement = TRUE
        AND ua.id IS NULL; -- Not yet earned
        
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    OPEN achievement_cursor;
    
    achievement_loop: LOOP
        FETCH achievement_cursor INTO v_achievement_id, v_unlock_conditions, v_xp_reward, v_coins_reward, v_gems_reward;
        
        IF done THEN
            LEAVE achievement_loop;
        END IF;
        
        -- Check if user meets achievement conditions
        -- This would need custom logic based on the JSON conditions
        -- For now, we'll do a basic example for task completion
        
        IF JSON_EXTRACT(v_unlock_conditions, '$.tasks_completed') IS NOT NULL THEN
            SET @required_tasks = JSON_EXTRACT(v_unlock_conditions, '$.tasks_completed');
            SET @user_completed_tasks = (
                SELECT COUNT(*) 
                FROM tbl_task_metadata 
                WHERE user_id = p_user_id AND status = 'completed'
            );
            
            IF @user_completed_tasks >= @required_tasks THEN
                -- Award achievement
                INSERT INTO tbl_user_achievements (
                    user_id, achievement_id, progress_current, progress_target, 
                    is_completed, completed_at, created_by
                ) VALUES (
                    p_user_id, v_achievement_id, @required_tasks, @required_tasks,
                    TRUE, NOW(), p_user_id
                );
                
                -- Award rewards
                UPDATE tbl_users 
                SET total_xp = total_xp + v_xp_reward,
                    current_xp = current_xp + v_xp_reward,
                    coins = coins + v_coins_reward,
                    gems = gems + v_gems_reward
                WHERE id = p_user_id;
                
                -- Create notification
                INSERT INTO tbl_notifications (user_id, type, title, message, created_by)
                SELECT p_user_id, 'achievement', 'Achievement Unlocked!', 
                       CONCAT('You earned the "', am.name, '" achievement!'), p_user_id
                FROM tbl_achievement_metadata am WHERE am.id = v_achievement_id;
            END IF;
        END IF;
        
    END LOOP;
    
    CLOSE achievement_cursor;
    COMMIT;
END //

-- Procedure to generate daily stats snapshot
CREATE PROCEDURE GenerateDailyStats(IN p_date DATE)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Generate daily stats for all active users
    INSERT INTO tbl_daily_stats (
        user_id, stat_date, tasks_completed, habits_completed, 
        journal_entries, xp_gained, level_at_end_of_day,
        physical_health, creativity, knowledge, happiness, money,
        active_streaks, achievements_earned, created_by
    )
    SELECT 
        u.id,
        p_date,
        COALESCE(task_stats.completed_count, 0),
        COALESCE(habit_stats.completed_count, 0),
        COALESCE(journal_stats.entry_count, 0),
        COALESCE(xp_stats.xp_gained, 0),
        u.level,
        us.physical_health,
        us.creativity,
        us.knowledge,
        us.happiness,
        us.money,
        COALESCE(streak_stats.active_streaks, 0),
        COALESCE(achievement_stats.earned_count, 0),
        1
    FROM tbl_users u
    LEFT JOIN tbl_user_stats us ON u.id = us.user_id
    
    -- Task completion stats
    LEFT JOIN (
        SELECT user_id, COUNT(*) as completed_count
        FROM tbl_task_metadata 
        WHERE DATE(completed_at) = p_date AND status = 'completed'
        GROUP BY user_id
    ) task_stats ON u.id = task_stats.user_id
    
    -- Habit completion stats  
    LEFT JOIN (
        SELECT hm.user_id, COUNT(*) as completed_count
        FROM tbl_habit_logs hl
        JOIN tbl_habit_metadata hm ON hl.habit_id = hm.id
        WHERE hl.log_date = p_date AND hl.completion_status = 'completed'
        GROUP BY hm.user_id
    ) habit_stats ON u.id = habit_stats.user_id
    
    -- Journal entry stats
    LEFT JOIN (
        SELECT user_id, COUNT(*) as entry_count
        FROM tbl_journal_entries 
        WHERE entry_date = p_date
        GROUP BY user_id
    ) journal_stats ON u.id = journal_stats.user_id
    
    -- XP gained calculation (tasks + habits)
    LEFT JOIN (
        SELECT 
            u2.id as user_id,
            COALESCE(task_xp.xp, 0) + COALESCE(habit_xp.xp, 0) as xp_gained
        FROM tbl_users u2
        LEFT JOIN (
            SELECT user_id, SUM(xp_reward) as xp
            FROM tbl_task_metadata 
            WHERE DATE(completed_at) = p_date AND status = 'completed'
            GROUP BY user_id
        ) task_xp ON u2.id = task_xp.user_id
        LEFT JOIN (
            SELECT hm.user_id, SUM(hm.xp_reward) as xp
            FROM tbl_habit_logs hl
            JOIN tbl_habit_metadata hm ON hl.habit_id = hm.id
            WHERE hl.log_date = p_date AND hl.completion_status = 'completed'
            GROUP BY hm.user_id
        ) habit_xp ON u2.id = habit_xp.user_id
    ) xp_stats ON u.id = xp_stats.user_id
    
    -- Active streaks
    LEFT JOIN (
        SELECT user_id, COUNT(*) as active_streaks
        FROM tbl_habit_streaks 
        WHERE current_streak > 0
        GROUP BY user_id
    ) streak_stats ON u.id = streak_stats.user_id
    
    -- Achievements earned today
    LEFT JOIN (
        SELECT user_id, COUNT(*) as earned_count
        FROM tbl_user_achievements 
        WHERE DATE(completed_at) = p_date AND is_completed = TRUE
        GROUP BY user_id
    ) achievement_stats ON u.id = achievement_stats.user_id
    
    WHERE u.is_active = TRUE
    
    ON DUPLICATE KEY UPDATE
        tasks_completed = VALUES(tasks_completed),
        habits_completed = VALUES(habits_completed),
        journal_entries = VALUES(journal_entries),
        xp_gained = VALUES(xp_gained),
        level_at_end_of_day = VALUES(level_at_end_of_day),
        physical_health = VALUES(physical_health),
        creativity = VALUES(creativity),
        knowledge = VALUES(knowledge),
        happiness = VALUES(happiness),
        money = VALUES(money),
        active_streaks = VALUES(active_streaks),
        achievements_earned = VALUES(achievements_earned),
        updated_at = CURRENT_TIMESTAMP;
    
    COMMIT;
END //

DELIMITER ;

-- =============================================================================
-- SCHEDULED EVENTS FOR AUTOMATION
-- =============================================================================

-- Enable event scheduler
SET GLOBAL event_scheduler = ON;

-- Daily cleanup event
CREATE EVENT IF NOT EXISTS ev_daily_cleanup
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURRENT_DATE + INTERVAL 1 DAY, '02:00:00')
DO
  CALL CleanupOldData();

-- Daily stats generation event
CREATE EVENT IF NOT EXISTS ev_daily_stats_generation
ON SCHEDULE EVERY 1 DAY  
STARTS TIMESTAMP(CURRENT_DATE + INTERVAL 1 DAY, '01:00:00')
DO
  CALL GenerateDailyStats(CURRENT_DATE - INTERVAL 1 DAY);

-- Weekly leaderboard update event
CREATE EVENT IF NOT EXISTS ev_weekly_leaderboard_update
ON SCHEDULE EVERY 1 WEEK
STARTS TIMESTAMP(DATE_ADD(DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY), INTERVAL 7 DAY), '03:00:00')
DO
  CALL UpdateLeaderboards();

-- =============================================================================
-- SECURITY AND PERMISSIONS
-- =============================================================================

-- Create application user with limited permissions
CREATE USER IF NOT EXISTS 'lifequest_app'@'localhost' IDENTIFIED BY 'SecurePassword123!';
CREATE USER IF NOT EXISTS 'lifequest_readonly'@'localhost' IDENTIFIED BY 'ReadOnlyPass456!';

-- Grant permissions to application user
GRANT SELECT, INSERT, UPDATE, DELETE ON lifequest_db.* TO 'lifequest_app'@'localhost';
GRANT EXECUTE ON lifequest_db.* TO 'lifequest_app'@'localhost';

-- Grant read-only permissions for reporting
GRANT SELECT ON lifequest_db.* TO 'lifequest_readonly'@'localhost';

-- Revoke dangerous permissions
REVOKE DROP, ALTER, CREATE, INDEX ON lifequest_db.* FROM 'lifequest_app'@'localhost';

FLUSH PRIVILEGES;

-- =============================================================================
-- FINAL OPTIMIZATIONS
-- =============================================================================

-- Analyze tables for optimizer statistics
ANALYZE TABLE tbl_users, tbl_task_metadata, tbl_habit_metadata, tbl_user_quests, 
             tbl_user_achievements, tbl_goal_metadata, tbl_journal_entries,
             tbl_daily_stats, tbl_leaderboard_entries;

-- =============================================================================
-- DATABASE DOCUMENTATION
-- =============================================================================

/*
LIFE QUEST DATABASE SCHEMA SUMMARY
==================================

CORE MODULES:
1. User Management (tbl_users, tbl_user_stats, tbl_system_settings)
2. Task Management (tbl_task_*, 3 tables)
3. Quest System (tbl_quest_*, 3 tables) 
4. Habit Tracking (tbl_habit_*, 3 tables)
5. Achievement System (tbl_achievement_*, 2 tables)
6. Goal Setting (tbl_goal_*, 3 tables)
7. Journal (tbl_journal_entries, 1 table)
8. Leaderboard (tbl_leaderboard_*, 2 tables)
9. Shop System (tbl_shop_*, 2 tables)
10. Social Features (tbl_social_*, tbl_user_friendships, 3 tables)
11. Notifications (tbl_notifications, tbl_reminders, 2 tables)
12. Analytics (tbl_daily_stats, tbl_user_sessions, 2 tables)
13. Audit & Backup (tbl_audit_logs, tbl_backup_logs, 2 tables)
14. Utilities (tbl_themes, tbl_user_themes, tbl_file_uploads, 3 tables)

TOTAL TABLES: 35 tables

KEY FEATURES:
- Modular design with clear separation of concerns
- Comprehensive indexing for performance
- Foreign key constraints for data integrity
- Automated triggers for common operations
- Stored procedures for complex business logic
- Views for common query patterns
- Scheduled events for maintenance
- Security with limited user permissions
- Full audit trail capability
- Scalable architecture supporting high-volume operations

PERFORMANCE CONSIDERATIONS:
- Composite indexes for common query patterns
- Partitioning ready for large tables (daily_stats, audit_logs)
- Efficient JSON storage for flexible data
- Optimized for both read and write operations
- Automated cleanup of old data

SECURITY FEATURES:
- Separate application and read-only database users
- Input validation through constraints
- Audit logging for sensitive operations
- Secure password hashing support
- File upload security considerations

MAINTENANCE:
- Automated daily cleanup procedures
- Statistics generation for reporting
- Leaderboard recalculation
- Backup logging and monitoring
- Performance optimization through analyze tables

This schema supports a production-ready gamified life dashboard application
with room for future expansion and millions of users.
*/

-- =============================================================================
-- END OF SCHEMA
-- =============================================================================

ALTER TABLE tbl_quest_logs 
ADD FOREIGN KEY (related_habit_id) REFERENCES tbl_habit_metadata(id) ON DELETE SET NULL;

ALTER TABLE tbl_goal_logs 
ADD FOREIGN KEY (related_habit_id) REFERENCES tbl_habit_metadata(id) ON DELETE SET NULL;

ALTER TABLE tbl_task_metadata 
DROP FOREIGN KEY tbl_task_metadata_ibfk_1,
ADD CONSTRAINT fk_task_user 
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE;

-- ISSUE 10: Potential data type overflow
-- PROBLEM: Some TINYINT UNSIGNED columns may be too small for rewards
-- FIX: Consider using SMALLINT for reward columns that might exceed 255
ALTER TABLE tbl_task_metadata 
MODIFY COLUMN health_reward SMALLINT UNSIGNED DEFAULT 0,
MODIFY COLUMN creativity_reward SMALLINT UNSIGNED DEFAULT 0,
MODIFY COLUMN knowledge_reward SMALLINT UNSIGNED DEFAULT 0,
MODIFY COLUMN happiness_reward SMALLINT UNSIGNED DEFAULT 0,
MODIFY COLUMN money_reward SMALLINT UNSIGNED DEFAULT 0;

-- =============================================================================
-- ADDITIONAL MISSING ELEMENTS
-- =============================================================================

-- Missing table: Theme-related tables referenced but not fully implemented
-- This seems to be partially implemented, check if complete

-- Missing indexes for performance on large tables
CREATE INDEX idx_audit_logs_partition ON tbl_audit_logs(created_at);
CREATE INDEX idx_daily_stats_partition ON tbl_daily_stats(stat_date);

-- Missing stored procedure parameter validation
-- Add parameter validation in stored procedures to prevent errors

-- Missing proper transaction isolation levels for concurrent operations
-- Consider adding SET TRANSACTION ISOLATION LEVEL READ COMMITTED; where needed

-- =============================================================================
-- RECOMMENDED IMPROVEMENTS
-- =============================================================================

-- 1. Add database version tracking
CREATE TABLE tbl_schema_versions (
    version VARCHAR(20) PRIMARY KEY,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT
);

INSERT INTO tbl_schema_versions VALUES ('1.0.0', NOW(), 'Initial schema creation');

-- 3. Add check constraints for data validation
ALTER TABLE tbl_user_stats 
ADD CONSTRAINT chk_health_range CHECK (physical_health BETWEEN 0 AND 100),
ADD CONSTRAINT chk_creativity_range CHECK (creativity BETWEEN 0 AND 100),
ADD CONSTRAINT chk_knowledge_range CHECK (knowledge BETWEEN 0 AND 100),
ADD CONSTRAINT chk_happiness_range CHECK (happiness BETWEEN 0 AND 100),
ADD CONSTRAINT chk_money_range CHECK (money BETWEEN 0 AND 100);