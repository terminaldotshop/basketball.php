<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

require_once("./app/PP.php");

class IrcMessage
{
    public function __construct(
        public string $raw,
        public ?string $prefix = null,
        public ?string $username = null,
        public ?string $command = null,
        public array $params = [],
        public ?string $channel = null,
        public ?string $message = null
    ) {
        $this->parseMessage();
    }

    private function parseMessage(): void
    {
        // Check if the message starts with a colon (':'), which usually indicates the presence of a prefix
        if ($this->raw[0] === ':') {
            // Extract the prefix (everything before the first space)
            $spacePos = strpos($this->raw, ' ');
            $this->prefix = substr($this->raw, 1, $spacePos - 1);
            $this->raw = substr($this->raw, $spacePos + 1);
        }

        // Extract the command (e.g., PRIVMSG)
        $spacePos = strpos($this->raw, ' ');
        $this->command = substr($this->raw, 0, $spacePos);
        $this->raw = substr($this->raw, $spacePos + 1);

        // Extract the parameters (e.g., channel and message)
        $params = explode(' :', $this->raw, 2);

        // First part is usually the channel name
        $this->params = explode(' ', $params[0]);
        $this->channel = $this->params[0];

        // If there is a message after the colon
        if (isset($params[1])) {
            $this->message = $params[1];
        }

        // Extract the username from the prefix
        if ($this->prefix) {
            $exclamationPos = strpos($this->prefix, '!');
            if ($exclamationPos !== false) {
                $this->username = substr($this->prefix, 0, $exclamationPos);
            }
        }
    }

    public function prettyPrint(): string
    {
        // Format the message for pretty printing
        $output = "IRC Message:\n";
        $output .= "-------------------------\n";
        $output .= sprintf("Username: %s\n", $this->username ?? 'N/A');
        $output .= sprintf("Message: %s\n", $this->message ?? 'N/A');
        $output .= "-------------------------\n";

        return $output;
    }
}

class IrcListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:irc-listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* $bot =  new \App\Irc\Bot('teej_dv', 'irc.chat.twitch.tv'); */
        /* $bot->on('connecting', function () { */
        /*     echo "Connecting...\n"; */
        /* })->on('connected', function () { */
        /*     echo "Connected!\n"; */
        /* })->on('chat', function ($e, $bot) { */
        /*     echo "CHAT($e->channel): $e->from: $e->text\n"; */
        /* })->on('welcome', function ($e, $bot) { */
        /*     //We list all the channels. This will trigger the 'list' event */
        /*     $bot->listChannels(); */
        /* }) */
        /**/
        /* ; */
        /**/
        /* $bot->connect(); */

        $server = 'irc.chat.twitch.tv';
        $port = 6667;
        $nickname = 'teej_dv';
        $token = env('TWITCH_OAUTH_TOKEN');

        // Connect to the IRC server
        $errNo = null;
        $errStr = null;
        $socket = @fsockopen($server, $port, $errNo, $errStr, 30);

        echo "errNo: $errNo\n";
        echo "errStr: $errStr\n";

        if (!$socket) {
            die("Unable to connect to IRC server\n");
        } else {
            echo "Connected to IRC\n";
        }

        $eof = feof($socket);
        if ($eof) {
            die("Connection closed immediately after opening.\n");
        }

        // Send authentication details
        fwrite($socket, "PASS $token\r\n");
        fwrite($socket, "NICK $nickname\r\n");

        // Join a channel
        $channel = '#ThePrimeagen';
        fwrite($socket, "JOIN $channel\r\n");
        echo "Joined $channel\n";

        $eof = feof($socket);
        if ($eof) {
            echo "OH NO";
            die("Connection closed immediately after opening.\n");
        }


        while (!feof($socket)) {
            $data = fgets($socket, 512);
            // Respond to PINGs to keep the connection alive
            if (strpos($data, 'PING') !== false) {
                fwrite($socket, "PONG :tmi.twitch.tv\r\n");
                continue;
            }


            $message = new IrcMessage($data);
            Cache::increment("message_count");
            $count = Cache::get("message_count");
            echo "$count\n";

            $predictions = [
                new \App\PPPredictionOption("Adam Almore", 250),
                new \App\PPPredictionOption("ThePrimeagen", 1000),
                new \App\PPPredictionOption("teej_dv", 35),
            ];

            $predictions = array_map(function ($prediction) {
                return [
                    'option' => $prediction->option,
                    'points' => $prediction->points,
                ];
            }, $predictions);

            Cache::set("prediction_prompt", "Who misses the first shot");
            Cache::set("prediction_options", $predictions);

            /* // Example: Send a message to the channel */
            /* if (strpos($data, '!hello') !== false) { */
            /*     fwrite($socket, "PRIVMSG $channel :Hello, World!\r\n"); */
            /* } */
        }

        // Close the connection
        fclose($socket);
    }
}
