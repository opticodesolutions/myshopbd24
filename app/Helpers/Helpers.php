<?php

namespace App\Helpers;

use App\Models\Customer;

class Helpers
{
    public function getTree($referCode, $currentLevel = 1, $maxLevel = 12)
    {
        // Stop recursion if the current level exceeds the maximum level
        if ($currentLevel > $maxLevel) {
            return null;
        }

        // Fetch the root customer
        $customer = Customer::with('user')->where('refer_code', $referCode)->first();

        if (!$customer) {
            return null;
        }

        // Fetch left and right children
        $leftChild = Customer::where('refer_by', $referCode)->where('position', 'left')->first();
        $rightChild = Customer::where('refer_by', $referCode)->where('position', 'right')->first();

        return [
            'customer' => $customer,
            'user_id' => $customer->user->id, 
            'level' => $currentLevel,
            'left' => $leftChild ? $this->getTree($leftChild->refer_code, $currentLevel + 1, $maxLevel) : null,
            'right' => $rightChild ? $this->getTree($rightChild->refer_code, $currentLevel + 1, $maxLevel) : null,
        ];
    }

    public function collectUsersByLevel($tree, &$userLevels)
    {
        if ($tree) {
            // Add user ID to the corresponding level
            $level = $tree['level'];
            $userLevels[$level][] = $tree['user_id'];

            // Recursively collect users from left and right subtrees
            $this->collectUsersByLevel($tree['left'], $userLevels);
            $this->collectUsersByLevel($tree['right'], $userLevels);
        }
    }
}

