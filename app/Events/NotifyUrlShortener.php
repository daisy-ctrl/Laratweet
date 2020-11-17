<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Bitly\BitlyProvider;
use Mremi\UrlShortener\Provider\Bitly\OAuthClient;
use Mremi\UrlShortener\Provider\Bitly\GenericAccessTokenAuthenticator;class NotifyUrlShortener
{
    ...    /**
     * Handle the event.
     *
     * @param  LinkCreated  $event
     * @return void
     */
    public function handle(LinkCreated $event)
    {
        $link = new Link;
        $link->setLongUrl($event->link->url);
        $bitlyProvider = new BitlyProvider(
            new GenericAccessTokenAuthenticator(env('BITLY_GENERIC_ACCESS_TOKEN')),
            array('connect_timeout' => 10, 'timeout' => 10)
        );
         $bitlyProvider->shorten($link);
         $event->link->short_url = $link->getShortUrl();
         $event->link->save();
    }
}
