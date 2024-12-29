<?php

namespace App\Helpers;

use App\Models\Customer;
use App\Models\IncentiveIncome;

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
    /**
     * Recursively collects the user IDs in the tree for the given root refer code and maximum level, and stores them in the given associative array.
     *
     * The associative array is indexed by the level number, and the values are arrays of user IDs at that level.
     *
     * @param array $tree The binary tree node to traverse
     * @param array &$userLevels The associative array to store the user IDs in
     */

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

    /**
     * Gets the total number of users in the tree for the given refer code and maximum level.
     *
     * @param string $referCode The refer code to get the total users for
     * @param int $maxLevel The maximum level to traverse when getting the total users
     *
     * @return int The total number of users in the tree
     */
    public function getTotalUsersForRoot($referCode, $maxLevel = 12)
    {
        $tree = $this->getTree($referCode, 1, $maxLevel);
        return $this->countUsersInTree($tree);
    }

    /**
     * Gets all the child users' IDs in the tree for the given refer code and maximum level.
     *
     * @param string $referCode The refer code to get the child users for
     * @param int $maxLevel The maximum level to traverse when getting the child users
     *
     * @return array<int> The IDs of the child users
     */
    public function getAllChildUsersIdsForRoot($referCode, $maxLevel = 12)
    {
        $tree = $this->getTree($referCode, 1, $maxLevel);
        $userIds = [];
        $this->collectUserIdsInTree($tree, $userIds);
        return $userIds;
    }

    /**
     * Recursively counts the total number of users in the tree for the given tree node.
     *
     * @param array $tree The tree node to count users for
     *
     * @return int The total number of users in the tree
     */
    private function countUsersInTree($tree)
    {
        if (!$tree) {
            return 0;
        }

        // Count the current user and its children recursively
        $leftCount = $this->countUsersInTree($tree['left']);
        $rightCount = $this->countUsersInTree($tree['right']);

        return 1 + $leftCount + $rightCount; // 1 for the current user
    }

    /**
     * Recursively collects all the user IDs in the tree for the given tree node.
     *
     * @param array $tree The tree node to collect user IDs for
     * @param array &$userIds The array to store the collected user IDs in
     */
    private function collectUserIdsInTree($tree, &$userIds)
    {
        if (!$tree) {
            return;
        }
        // Add the user ID of the current node
        $userIds[] = $tree['user_id'];
        // Recursively collect user IDs from the left and right subtrees
        $this->collectUserIdsInTree($tree['left'], $userIds);
        $this->collectUserIdsInTree($tree['right'], $userIds);
    }

    /**
     * Gets all the user IDs at the given level for the given refer code and maximum level.
     *
     * @param string $referCode The refer code to get the user IDs for
     * @param int $level The level to get the user IDs for
     * @param int $maxLevel The maximum level to traverse when getting the user IDs
     *
     * @return array<int> The user IDs at the given level
     */
    public function getUsersIdsForLevel($referCode, $level, $maxLevel = 12)
    {
        $tree = $this->getTree($referCode, 1, $maxLevel);
        $userIdsAtLevel = [];
        $this->collectUserIdsForSpecificLevel($tree, $level, $userIdsAtLevel);
        return $userIdsAtLevel;
    }
    /**
     * Recursively collects all the user IDs at the given level for the given tree node.
     *
     * @param array $tree The tree node to collect user IDs for
     * @param int $targetLevel The level to get the user IDs for
     * @param array &$userIdsAtLevel The array to store the collected user IDs in
     */
    private function collectUserIdsForSpecificLevel($tree, $targetLevel, &$userIdsAtLevel)
    {
        if (!$tree) {
            return;
        }

        if ($tree['level'] == $targetLevel) {
            // Add the user ID if we're at the target level
            $userIdsAtLevel[] = $tree['user_id'];
        }

        // Recursively collect user IDs from the left and right subtrees
        $this->collectUserIdsForSpecificLevel($tree['left'], $targetLevel, $userIdsAtLevel);
        $this->collectUserIdsForSpecificLevel($tree['right'], $targetLevel, $userIdsAtLevel);
    }


    /**
     * Given a total user count, returns the last matching designation name from the IncentiveIncome table.
     * The designation name is determined by finding the last matching child_and_children value in the table
     * that is greater than or equal to the given total user count.
     *
     * @param int $totalUserCount The total user count to find the matching designation for
     *
     * @return string|null The last matching designation name, or null if no match is found
     */
    public function GetDesignation($totalUserCount){
        $designations =IncentiveIncome::all();
        $lastMatchingDesignation = null;
        foreach ($designations as $value) {
            if ($totalUserCount >= $value->child_and_children) {
                $lastMatchingDesignation = $value->designation_name; 
            }
        }
        return $lastMatchingDesignation;
    }
}

