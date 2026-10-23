-- Migra o vínculo legado id_contato para id_cliente sem usar tbl_contato.
-- Execute uma vez em bancos já inicializados com Pingodecor.sql antigo.

INSERT INTO tbl_cliente (
    id_cliente,
    nome_cliente,
    email_cliente,
    senha_cliente,
    foto_cliente,
    status_cliente
)
SELECT DISTINCT
    orcamento.id_contato,
    CONCAT('Cliente legado ', orcamento.id_contato),
    CONCAT('orcamento.cliente.', orcamento.id_contato, '@pingodecor.local'),
    '123456',
    'imagem-indisponivel.svg',
    'Ativo'
FROM tbl_orcamento AS orcamento
LEFT JOIN tbl_cliente AS cliente
    ON cliente.id_cliente = orcamento.id_contato
WHERE cliente.id_cliente IS NULL;

SET @orcamento_fk_exists = (
    SELECT COUNT(*)
    FROM information_schema.table_constraints
    WHERE constraint_schema = DATABASE()
      AND table_name = 'tbl_orcamento'
      AND constraint_name = 'fk_orcamento_contato'
      AND constraint_type = 'FOREIGN KEY'
);
SET @orcamento_fk_sql = IF(
    @orcamento_fk_exists > 0,
    'ALTER TABLE tbl_orcamento DROP FOREIGN KEY fk_orcamento_contato',
    'SELECT 1'
);
PREPARE orcamento_fk_stmt FROM @orcamento_fk_sql;
EXECUTE orcamento_fk_stmt;
DEALLOCATE PREPARE orcamento_fk_stmt;

SET @orcamento_index_exists = (
    SELECT COUNT(*)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'tbl_orcamento'
      AND index_name = 'fk_orcamento_contato'
);
SET @orcamento_index_sql = IF(
    @orcamento_index_exists > 0,
    'ALTER TABLE tbl_orcamento DROP INDEX fk_orcamento_contato',
    'SELECT 1'
);
PREPARE orcamento_index_stmt FROM @orcamento_index_sql;
EXECUTE orcamento_index_stmt;
DEALLOCATE PREPARE orcamento_index_stmt;

ALTER TABLE tbl_orcamento
    CHANGE COLUMN id_contato id_cliente INT NOT NULL,
    ADD INDEX fk_orcamento_cliente (id_cliente),
    ADD CONSTRAINT fk_orcamento_cliente
        FOREIGN KEY (id_cliente) REFERENCES tbl_cliente (id_cliente);
