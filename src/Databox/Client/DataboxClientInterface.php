<?php
namespace Databox\Client;

use Databox\DataboxBuilder;
/**
 * This interface should go in Databox-PHP-SDK.
 * DataboxClient should implement this interface (setPushData() should be refactored to pushData).
 *
 * @author Uroš Majerič
 *
 */
interface DataboxClientInterface
{

    /**
     *
     * @param DataboxBuilder $dataProvider Data to be pushed
     *
     * @return array The server response.
     */
    public function pushData(DataboxBuilder $dataProvider);

    /**
     * Method clears the data for space accesstoken
     */
    public function clearRemoteData();

}