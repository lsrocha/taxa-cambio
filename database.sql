CREATE DATABASE IF NOT EXISTS exchange_rates
    COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS exchange_rates.currencies (
    code VARCHAR(3) NOT NULL,
    value FLOAT(15,10) NULL,
    PRIMARY KEY(code)
);
