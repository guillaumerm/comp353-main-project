ALTER TABLE `interest_rate` DROP FOREIGN KEY `Interest_rate_ibfk_1`;
ALTER TABLE `interest_rate` DROP FOREIGN KEY `Interest_rate_ibfk_2`;
ALTER TABLE `account` DROP FOREIGN KEY `account_ibfk_1`;
ALTER TABLE `account` DROP FOREIGN KEY `charge_plan_no`;
ALTER TABLE `account` DROP FOREIGN KEY `fk_account_account_type_id`;
ALTER TABLE `account` DROP FOREIGN KEY `option_id`;
ALTER TABLE `branch` DROP FOREIGN KEY `fk_manager_branch`;
ALTER TABLE `branchAcc` DROP FOREIGN KEY `branchAcc_ibfk_1`;
ALTER TABLE `branchAcc` DROP FOREIGN KEY `branchAcc_ibfk_2`;
ALTER TABLE `branchAcc` DROP FOREIGN KEY `branchAcc_ibfk_3`;
ALTER TABLE `charge_plan` DROP FOREIGN KEY `charge_plan_ibfk_1`;
ALTER TABLE `employee` DROP FOREIGN KEY `employee_ibfk_1`;
ALTER TABLE `account_option` DROP FOREIGN KEY `options_ibfk_1`;
ALTER TABLE `service` DROP FOREIGN KEY `services_ibfk_1`;
ALTER TABLE `transaction` DROP FOREIGN KEY `transaction_ibfk_1`;
ALTER TABLE `branch` DROP FOREIGN KEY `fk_branch_address_1`;
ALTER TABLE `employee` DROP FOREIGN KEY `fk_employee_address_1`;
ALTER TABLE `client` DROP FOREIGN KEY `fk_client_client_category_1`;
ALTER TABLE `fund_transfer` DROP FOREIGN KEY `fk_money_transfer_client_1`;
ALTER TABLE `fund_transfer` DROP FOREIGN KEY `fk_money_transfer_client_2`;
ALTER TABLE `payee` DROP FOREIGN KEY `fk_payee_client_1`;
ALTER TABLE `bill_payment` DROP FOREIGN KEY `fk_bill_payment_payee_1`;
ALTER TABLE `fund_transfer` DROP FOREIGN KEY `fk_fund_transfer_account_1`;
ALTER TABLE `fund_transfer` DROP FOREIGN KEY `fk_fund_transfer_account_2`;
ALTER TABLE `celebrate` DROP FOREIGN KEY `fk_celebrate_holiday_id`;
ALTER TABLE `celebrate` DROP FOREIGN KEY `fk_celebrate_province`;
ALTER TABLE `address` DROP FOREIGN KEY `fk_address_province`;
ALTER TABLE `absence` DROP FOREIGN KEY `fk_absence_employee_id`;
ALTER TABLE `absence` DROP FOREIGN KEY `fk_absence_absence_type_id`;
ALTER TABLE `employee` DROP FOREIGN KEY `fk_employee_employee_title`;
ALTER TABLE `bill_payment` DROP FOREIGN KEY `fk_bill_payment_account_no`;
ALTER TABLE `recurring_bill_payment` DROP FOREIGN KEY `fk_recurring_bill_payment_account_no`;
ALTER TABLE `recurring_bill_payment` DROP FOREIGN KEY `fk_recurring_bill_payment_payee`;
ALTER TABLE `schedule` DROP FOREIGN KEY `fk_schedule_employee_id`;
ALTER TABLE `recurring_bill_payment` DROP FOREIGN KEY `fk_recurring_bill_payment_frequency`;
ALTER TABLE `frequency` DROP FOREIGN KEY `fk_frequency_time_unit`;

DROP VIEW `client_view`;
DROP VIEW `branch_view`;
DROP VIEW `employee_view`;
DROP INDEX `service_id` ON `interest_rate`;
DROP INDEX `client_id` ON `account`;
DROP INDEX `fk_account_account_type_id` ON `account`;
DROP INDEX `option_id` ON `account`;
DROP INDEX `charge_plan_no` ON `account`;
DROP INDEX `fk_manager_branch` ON `branch`;
DROP INDEX `branch_id` ON `branchAcc`;
DROP INDEX `service_id` ON `branchAcc`;
DROP INDEX `option_id` ON `charge_plan`;
DROP INDEX `branch_id` ON `employee`;
DROP INDEX `account_type_id` ON `account_option`;
DROP INDEX `service_manager_id` ON `service`;
DROP INDEX `account_no` ON `transaction`;

DROP TABLE `interest_rate`;
DROP TABLE `account`;
DROP TABLE `account_type`;
DROP TABLE `branch`;
DROP TABLE `branchAcc`;
DROP TABLE `charge_plan`;
DROP TABLE `client`;
DROP TABLE `employee`;
DROP TABLE `account_option`;
DROP TABLE `service`;
DROP TABLE `transaction`;
DROP TABLE `address`;
DROP TABLE `schedule`;
DROP TABLE `absence`;
DROP TABLE `absence_type`;
DROP TABLE `province`;
DROP TABLE `holiday`;
DROP TABLE `celebrate`;
DROP TABLE `employee_title`;
DROP TABLE `client_category`;
DROP TABLE `fund_transfer`;
DROP TABLE `payee`;
DROP TABLE `bill_payment`;
DROP TABLE `recurring_bill_payment`;
DROP TABLE `frequency`;
DROP TABLE `table_1`;
DROP TABLE `time_unit`;

CREATE TABLE `interest_rate` (
`percentage` decimal(3,3) NOT NULL,
`account_type_id` int(11) NOT NULL,
`service_id` int(11) NOT NULL,
PRIMARY KEY (`account_type_id`, `service_id`) ,
INDEX `service_id` (`service_id` ASC) USING BTREE
);
CREATE TABLE `account` (
`account_no` int(11) NOT NULL AUTO_INCREMENT,
`balance` decimal(11,2) NOT NULL DEFAULT 0.00,
`client_id` int(11) NOT NULL,
`account_type_id` int(11) NOT NULL,
`account_option_id` int(11) NOT NULL,
`charge_plan_no` int(11) NOT NULL,
PRIMARY KEY (`account_no`) ,
INDEX `client_id` (`client_id` ASC) USING BTREE,
INDEX `fk_account_account_type_id` (`account_type_id` ASC) USING BTREE,
INDEX `option_id` (`account_option_id` ASC) USING BTREE,
INDEX `charge_plan_no` (`charge_plan_no` ASC) USING BTREE
);
CREATE TABLE `account_type` (
`account_type_id` int(11) NOT NULL AUTO_INCREMENT,
`type` varchar(50) NOT NULL,
PRIMARY KEY (`account_type_id`) 
);
CREATE TABLE `branch` (
`branch_id` int(11) NOT NULL AUTO_INCREMENT,
`opening_date` date NOT NULL,
`phone` char(10) NOT NULL,
`fax` char(10) NULL,
`manager_id` int(11) NOT NULL,
`address_id` int(11) NOT NULL,
PRIMARY KEY (`branch_id`) ,
INDEX `fk_manager_branch` (`manager_id` ASC) USING BTREE
);
CREATE TABLE `branchAcc` (
`account_no` int(11) NOT NULL,
`branch_id` int(11) NOT NULL,
`service_id` int(11) NOT NULL,
PRIMARY KEY (`account_no`, `branch_id`, `service_id`) ,
INDEX `branch_id` (`branch_id` ASC) USING BTREE,
INDEX `service_id` (`service_id` ASC) USING BTREE
);
CREATE TABLE `charge_plan` (
`charge_plan_no` int(11) NOT NULL AUTO_INCREMENT,
`option_id` int(11) NOT NULL,
`charge` decimal(11,2) NOT NULL,
`plan_limit` decimal(11,2) NOT NULL,
`description` varchar(50) NOT NULL,
PRIMARY KEY (`charge_plan_no`, `option_id`) ,
INDEX `option_id` (`option_id` ASC) USING BTREE
);
CREATE TABLE `client` (
`client_id` int(11) NOT NULL AUTO_INCREMENT,
`joining_date` date NOT NULL,
`first_name` varchar(45) NOT NULL,
`last_name` varchar(45) NOT NULL,
`gender` char(1) NOT NULL DEFAULT 'U',
`phone_number` char(10) NOT NULL,
`dob` date NOT NULL,
`email` varchar(50) NOT NULL,
`client_category_id` int(11) NOT NULL,
`address_id` int(11) NULL,
`password` varchar(255) NULL,
PRIMARY KEY (`client_id`) 
);
CREATE TABLE `employee` (
`employee_id` int(11) NOT NULL AUTO_INCREMENT,
`first_name` varchar(45) NOT NULL,
`last_name` varchar(45) NOT NULL,
`gender` char(1) NOT NULL DEFAULT 'U',
`dob` date NOT NULL,
`email` varchar(50) NOT NULL,
`employee_title_id` int(11) NOT NULL,
`start_date` date NOT NULL,
`salary` int(11) NULL DEFAULT NULL,
`branch_id` int(11) NOT NULL,
`address_id` int(11) NULL,
`password` varchar(255) NULL,
PRIMARY KEY (`employee_id`) ,
INDEX `branch_id` (`branch_id` ASC) USING BTREE
);
CREATE TABLE `account_option` (
`account_option_id` int(11) NOT NULL AUTO_INCREMENT,
`description` varchar(50) NOT NULL,
`account_type_id` int(11) NOT NULL,
PRIMARY KEY (`account_option_id`) ,
INDEX `account_type_id` (`account_type_id` ASC) USING BTREE
);
CREATE TABLE `service` (
`service_id` int(11) NOT NULL AUTO_INCREMENT,
`service_manager_id` int(11) NOT NULL,
`description` varchar(30) NOT NULL,
PRIMARY KEY (`service_id`) ,
INDEX `service_manager_id` (`service_manager_id` ASC) USING BTREE
);
CREATE TABLE `transaction` (
`account_no` int(11) NOT NULL,
`transaction_no` int(11) NOT NULL AUTO_INCREMENT,
`date` date NOT NULL,
`amount` decimal(11,2) NOT NULL,
PRIMARY KEY (`transaction_no`, `account_no`) ,
INDEX `account_no` (`account_no` ASC) USING BTREE
);
CREATE TABLE `address` (
`address_id` int(11) NOT NULL,
`street` varchar(255) NOT NULL,
`apt` varchar(255) NULL,
`city` varchar(255) NOT NULL,
`postal_code` varchar(255) NOT NULL,
`province` char(2) NOT NULL,
PRIMARY KEY (`address_id`) 
);
CREATE TABLE `schedule` (
`date` date NOT NULL,
`employee_id` int(11) NOT NULL,
`start_time` time NULL,
`end_time` time NULL,
PRIMARY KEY (`employee_id`, `date`) 
);
CREATE TABLE `absence` (
`employee_id` int(11) NOT NULL,
`date` date NOT NULL,
`absence_type_id` int(11) NOT NULL,
PRIMARY KEY (`employee_id`, `date`) 
);
CREATE TABLE `absence_type` (
`absence_type_id` int(11) NOT NULL,
`name` varchar(255) NULL,
PRIMARY KEY (`absence_type_id`) 
);
CREATE TABLE `province` (
`code` char(2) NOT NULL,
`name` varchar(255) NULL,
PRIMARY KEY (`code`) 
);
CREATE TABLE `holiday` (
`holiday_id` int(11) NOT NULL,
`name` varchar(255) NULL,
`date` date NOT NULL,
PRIMARY KEY (`holiday_id`) 
);
CREATE TABLE `celebrate` (
`holiday_id` int(11) NOT NULL,
`province` char(255) NOT NULL,
PRIMARY KEY (`holiday_id`, `province`) 
);
CREATE TABLE `employee_title` (
`employee_title_id` int(11) NOT NULL,
`description` varchar(255) NULL,
PRIMARY KEY (`employee_title_id`) 
);
CREATE TABLE `client_category` (
`client_category_id` int(11) NOT NULL,
`name` varchar(255) NULL,
PRIMARY KEY (`client_category_id`) 
);
CREATE TABLE `fund_transfer` (
`from_client_id` int(11) NOT NULL,
`to_client_id` int(11) NOT NULL,
`date_sent` datetime NOT NULL,
`date_received` datetime NOT NULL,
`from_account_no` int(11) NOT NULL,
`to_account_no` int(11) NOT NULL,
`amount` decimal(11,2) NOT NULL,
PRIMARY KEY (`from_client_id`) 
);
CREATE TABLE `payee` (
`payee_id` int(11) NOT NULL,
`name` varchar(255) NULL,
`account_no` int(11) NOT NULL,
`client_id` int(11) NOT NULL,
PRIMARY KEY (`payee_id`) 
);
CREATE TABLE `bill_payment` (
`bill_payment_id` int(11) NOT NULL,
`amount` varchar(255) NOT NULL,
`date` datetime NOT NULL,
`payee_id` int(11) NOT NULL,
`from_account_no` int(11) NOT NULL,
PRIMARY KEY (`bill_payment_id`) 
);
CREATE TABLE `recurring_bill_payment` (
`recurring_bill_payment_id` int(255) NOT NULL,
`payee_id` int(11) NOT NULL,
`from_date` datetime NOT NULL,
`to_date` datetime NOT NULL,
`from_account_no` int(11) NOT NULL,
`frequency_id` int(11) NOT NULL,
`amount` varchar(255) NOT NULL,
PRIMARY KEY (`recurring_bill_payment_id`) 
);
CREATE TABLE `frequency` (
`frequency_id` int(11) NOT NULL,
`interval` timestamp NOT NULL,
`description` varchar(255) NULL,
`time_unit_id` int NOT NULL,
PRIMARY KEY (`frequency_id`) 
);
CREATE TABLE `table_1` (
);
CREATE TABLE `time_unit` (
`time_unit_id` int(11) NOT NULL,
`abbreviation` varchar(255) NULL,
`name` varchar(255) NULL,
PRIMARY KEY (`time_unit_id`) 
);

ALTER TABLE `interest_rate` ADD CONSTRAINT `Interest_rate_ibfk_1` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`account_type_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `interest_rate` ADD CONSTRAINT `Interest_rate_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `account` ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `account` ADD CONSTRAINT `charge_plan_no` FOREIGN KEY (`charge_plan_no`) REFERENCES `charge_plan` (`charge_plan_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `account` ADD CONSTRAINT `fk_account_account_type_id` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`account_type_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `account` ADD CONSTRAINT `option_id` FOREIGN KEY (`account_option_id`) REFERENCES `account_option` (`account_option_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `branch` ADD CONSTRAINT `fk_manager_branch` FOREIGN KEY (`manager_id`) REFERENCES `employee` (`employee_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `branchAcc` ADD CONSTRAINT `branchAcc_ibfk_1` FOREIGN KEY (`account_no`) REFERENCES `account` (`account_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `branchAcc` ADD CONSTRAINT `branchAcc_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `branchAcc` ADD CONSTRAINT `branchAcc_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `charge_plan` ADD CONSTRAINT `charge_plan_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `account_option` (`account_option_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `employee` ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `account_option` ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`account_type_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `service` ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`service_manager_id`) REFERENCES `employee` (`employee_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `transaction` ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`account_no`) REFERENCES `account` (`account_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `branch` ADD CONSTRAINT `fk_branch_address_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);
ALTER TABLE `employee` ADD CONSTRAINT `fk_employee_address_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);
ALTER TABLE `client` ADD CONSTRAINT `fk_client_client_category_1` FOREIGN KEY (`client_category_id`) REFERENCES `client_category` (`client_category_id`);
ALTER TABLE `fund_transfer` ADD CONSTRAINT `fk_money_transfer_client_1` FOREIGN KEY (`from_client_id`) REFERENCES `client` (`client_id`);
ALTER TABLE `fund_transfer` ADD CONSTRAINT `fk_money_transfer_client_2` FOREIGN KEY (`to_client_id`) REFERENCES `client` (`client_id`);
ALTER TABLE `payee` ADD CONSTRAINT `fk_payee_client_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`);
ALTER TABLE `bill_payment` ADD CONSTRAINT `fk_bill_payment_payee_1` FOREIGN KEY (`payee_id`) REFERENCES `payee` (`payee_id`);
ALTER TABLE `fund_transfer` ADD CONSTRAINT `fk_fund_transfer_account_1` FOREIGN KEY (`to_account_no`) REFERENCES `account` (`account_no`);
ALTER TABLE `fund_transfer` ADD CONSTRAINT `fk_fund_transfer_account_2` FOREIGN KEY (`from_account_no`) REFERENCES `account` (`account_no`);
ALTER TABLE `celebrate` ADD CONSTRAINT `fk_celebrate_holiday_id` FOREIGN KEY (`holiday_id`) REFERENCES `holiday` (`holiday_id`) ON DELETE CASCADE;
ALTER TABLE `celebrate` ADD CONSTRAINT `fk_celebrate_province` FOREIGN KEY (`province`) REFERENCES `province` (`code`) ON DELETE CASCADE;
ALTER TABLE `address` ADD CONSTRAINT `fk_address_province` FOREIGN KEY (`province`) REFERENCES `province` (`code`);
ALTER TABLE `absence` ADD CONSTRAINT `fk_absence_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;
ALTER TABLE `absence` ADD CONSTRAINT `fk_absence_absence_type_id` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_type` (`absence_type_id`);
ALTER TABLE `employee` ADD CONSTRAINT `fk_employee_employee_title` FOREIGN KEY (`employee_title_id`) REFERENCES `employee_title` (`employee_title_id`);
ALTER TABLE `bill_payment` ADD CONSTRAINT `fk_bill_payment_account_no` FOREIGN KEY (`from_account_no`) REFERENCES `account` (`account_no`);
ALTER TABLE `recurring_bill_payment` ADD CONSTRAINT `fk_recurring_bill_payment_account_no` FOREIGN KEY (`from_account_no`) REFERENCES `account` (`account_no`) ON DELETE CASCADE;
ALTER TABLE `recurring_bill_payment` ADD CONSTRAINT `fk_recurring_bill_payment_payee` FOREIGN KEY (`payee_id`) REFERENCES `payee` (`payee_id`) ON DELETE CASCADE;
ALTER TABLE `schedule` ADD CONSTRAINT `fk_schedule_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;
ALTER TABLE `recurring_bill_payment` ADD CONSTRAINT `fk_recurring_bill_payment_frequency` FOREIGN KEY (`frequency_id`) REFERENCES `frequency` (`frequency_id`);
ALTER TABLE `frequency` ADD CONSTRAINT `fk_frequency_time_unit` FOREIGN KEY (`time_unit_id`) REFERENCES `time_unit` (`time_unit_id`);

CREATE 
VIEW `client_view` AS 
SELECT
client.client_id,
client.joining_date,
client.first_name,
client.last_name,
client.gender,
client.phone_number,
address.street,
address.city,
address.apt,
address.postal_code,
address.province
FROM
client JOIN address;
CREATE 
VIEW `branch_view` AS 
SELECT
branch.branch_id,
branch.opening_date,
branch.phone,
branch.manager_id,
branch.fax,
address.street,
address.apt,
address.city,
address.postal_code,
address.province
FROM
branch JOIN address;
CREATE 
VIEW `employee_view` AS 
SELECT
employee.employee_id,
employee.first_name,
employee.last_name,
employee.gender,
employee.dob,
employee.email,
address.street,
address.apt,
address.city,
address.province,
address.postal_code
FROM
employee JOIN address;
