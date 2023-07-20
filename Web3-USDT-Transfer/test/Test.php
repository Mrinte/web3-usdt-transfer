<?php

/**
 * 本插件用于币安智能链（BNB Chain）的USDT插件转账，其它代币可自行修改ABI和网络URL、合约ABI进行使用；
 * (c) MrInte <617893305@qq.com>
 * @author MrInte <617893305@qq.com>
 * @license MIT
 */

namespace Test\MrInte\Web3USDTTransfer;

use MrInte\Web3USDTTransfer\Web3USDTTransfer;

class Test{
    public function USDTTransfer(){
        $Web3USDTTransfer = new Web3USDTTransfer();
        $Web3USDTTransferCreate = $Web3USDTTransfer->USDTTransfer();
        Demp($Web3USDTTransferCreate);
    }
}