<?php
/**
 *
 * @author GRICOLAT Didier
 */
interface iModel {

    public function add(object $datas,object $datas2): array;
    public function delete($params);

    public function update($params);

    public function get( string $params): array;

    public function count($param);

    public function exists($param);

    public function getList(array $param);
}
