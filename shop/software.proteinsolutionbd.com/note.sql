ALTER TABLE `receive` ADD `OtherReceiveInvoice` VARCHAR(50) NULL AFTER `CustomerReceiveInvoice`;
ALTER TABLE `receive` ADD `OtherID` INT NOT NULL AFTER `CustomerID`;
ALTER TABLE `receive` ADD INDEX(`OtherID`);

ALTER TABLE `payment` ADD `OtherPaymentInvoice` VARCHAR(50) NULL AFTER `SupplierPaymentInvoice`;
ALTER TABLE `payment` ADD `OtherID` INT NOT NULL AFTER `SupplierID`;
ALTER TABLE `payment` ADD INDEX(`OtherID`);

ALTER TABLE `payment` CHANGE `OtherPaymentInvoice` `OtherPaymentInvoice` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;