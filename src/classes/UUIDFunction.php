<?php
require_once sprintf('%s/src/classes/BaseConnection.php', $root);
final class UUIDFunction extends BaseConnection
{
    public function __construct()
    {
        parent::__construct();
        $this->conn->query(
            "CREATE OR REPLACE FUNCTION uuidv7(TIMESTAMPTZ DEFAULT clock_timestamp()) RETURNS UUID
            AS $$
                SELECT encode(
                    set_bit(
                        set_bit(
                            OVERLAY(uuid_send(gen_random_uuid()) PLACING
                                SUBSTRING(int8send((EXTRACT(EPOCH FROM $1) * 1000)::BIGINT) FROM 3)
                            FROM 1 FOR 6),
                        52, 1),
                    53, 1), 'hex')::UUID
            $$ LANGUAGE SQL VOLATILE PARALLEL SAFE",
        );
    }
}
