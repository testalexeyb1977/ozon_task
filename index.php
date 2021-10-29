<?php
declare(strict_types=1);

/**
 * I Задача о длиной цепочке единиц ⭐⭐
 *
 * Дана последоватльность 0 и 1
 * Нужно найти самую длинную последовательность из 1 (единиц) после удаления любого элемента
 *
 * func maxOnesAfterRemoveItem([]byte) uint
 *
 * assert(maxOnesAfterRemoveItem[0,0] == 0)
 * assert(maxOnesAfterRemoveItem[0,1] == 1)
 * assert(maxOnesAfterRemoveItem[1,0] == 1)
 * assert(maxOnesAfterRemoveItem[1,1] == 1)
 * assert(maxOnesAfterRemoveItem[1, 1, 0, 1, 1] == 4)
 * assert(maxOnesAfterRemoveItem[1, 1, 0, 1, 1, 0, 1, 1, 1] == 5)
 * assert(maxOnesAfterRemoveItem[1, 1, 0, 1, 1, 0, 1, 1, 1, 0] == 5)
 *
 * Что хочется увидеть:
 *
 * Алгоритм со сложностью O(N) по времени и O(1) по памяти
 */


function maxOnesAfterRemoveItem(array $line): int
{
    $totalCount = 0;
    $currentCount = 0;
    $currenZeroCount = 0;
    $currentUnitCount = 0;
    $itemFlag = true;
    $oneItemFlag = true;
    $lineCount = count($line);

    if ($lineCount <= 1) {
        return 0;
    }

    for ($i = 0; $i < $lineCount; ++$i) {

        if (!$itemFlag && $line[$i] === 1) {
            $itemFlag = true;
        }

        // unit
        if ($itemFlag && $line[$i] === 1) {
            ++$currentCount;
            ++$currentUnitCount;
        }

        //last
        if ($i === $lineCount - 1) {

            if ($line[$i] === 0) {
                $currentCount = (0 === $currentUnitCount) ? 0 : $currentCount;
                $currentCount = (isset($line[$i - 1]) && $line[$i - 1] === 0 && $currentCount > 2) ? --$currentCount : $currentCount;

            } elseif($currentUnitCount !== 1 && $oneItemFlag) {
                --$currentCount;
            }

            $totalCount = ($totalCount <= $currentCount) ? $currentCount : $totalCount;
            break;
        }

        // reset
        if ($itemFlag && $line[$i] === 0 && $currenZeroCount > 0) {
            $totalCount = ($totalCount <= $currentCount && 0 !== $currentUnitCount) ? $currentCount : $totalCount;

            $currenZeroCount = 0;
            $currentUnitCount = 0;
            $itemFlag = $oneItemFlag = false;
            $currentCount = 0;
        }

        // zero
        if ($itemFlag && $line[$i] === 0 && $currenZeroCount === 0) {
            $currentCount = ((isset($line[$i - 1]) && $line[$i - 1] !== 0) && (isset($line[$i + 1]) && $line[$i + 1] !== 0)) ? ++$currentCount : $currentCount;
            ++$currenZeroCount;
        }

    }

    return $totalCount;
}

assert(maxOnesAfterRemoveItem([0, 0]) === 0, RuntimeException::class);
assert(maxOnesAfterRemoveItem([0, 1]) === 1, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 0]) === 1, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1]) === 1, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1, 0, 1, 1]) === 4, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1, 0, 1, 1, 0, 1, 1, 1]) === 5, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1, 0, 1, 1, 0, 1, 1, 1, 0]) === 5, RuntimeException::class);

assert(maxOnesAfterRemoveItem([0, 0, 0, 0, 0, 0, 0, 0]) === 0, RuntimeException::class);
assert(maxOnesAfterRemoveItem([0, 0, 0]) === 0, RuntimeException::class);
assert(maxOnesAfterRemoveItem([0]) === 0, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1]) === 0, RuntimeException::class);
assert(maxOnesAfterRemoveItem([0, 0, 0, 0, 0, 1, 0, 0]) === 1, RuntimeException::class);
assert(maxOnesAfterRemoveItem([0, 0, 0, 0, 0, 0, 0, 1]) === 1, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 0, 0, 0, 0, 0, 0, 0]) === 1, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1, 1, 1, 1, 1, 1, 1]) === 7, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1, 1, 1]) === 3, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 1, 1]) === 2, RuntimeException::class);
assert(maxOnesAfterRemoveItem([1, 0, 0, 1, 1]) === 2, RuntimeException::class);


