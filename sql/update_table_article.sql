ALTER TABLE article ADD corrige           TINYINT(1) DEFAULT FALSE NOT NULL;
ALTER TABLE article ADD rapport           TEXT NOT NULL;
ALTER TABLE article ADD correcteur        VARCHAR(50) NOT NULL;