const express = require('express');
const cors = require('cors');
const axios = require('axios');

const app = express();
app.use(express.static('public'));
const PORT = process.env.PORT || 3000;

// Enable CORS so your frontend web tool can query this backend API easily
app.use(cors());
app.use(express.json());

// Base Check Route
app.get('/', (req, res) => {
    res.json({ status: "API is running smoothly", platform: "Pxxl Africa" });
});

/**
 * 📸 INSTAGRAM DOWNLOADER ENDPOINT
 */
app.post('/api/download/instagram', async (req, res) => {
    const { url } = req.body;
    if (!url) return res.status(400).json({ error: "Instagram URL is required" });

    try {
        // Clean URL to format it correctly for scraping/querying
        let cleanUrl = url.split('?')[0];
        if (!cleanUrl.endsWith('/')) cleanUrl += '/';
        const jsonUrl = `${cleanUrl}?__a=1&__d=dis`;

        // Setting a realistic User-Agent is essential to prevent rapid blocking/banning
        const response = await axios.get(jsonUrl, {
            headers: {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept-Language': 'en-US,en;q=0.9'
            }
        });

        // Parse through Instagram Graphql response safely
        const items = response.data?.graphql?.shortcode_media || response.data?.items?.[0];
        if (!items) {
            return res.status(404).json({ error: "Media not found or post is private. Consider using a proxy/cookie stack." });
        }

        let mediaUrl = "";
        let type = "";

        if (items.is_video || items.video_url) {
            mediaUrl = items.video_url;
            type = "video";
        } else {
            mediaUrl = items.display_url || items.image_versions2?.candidates?.[0]?.url;
            type = "image";
        }

        return res.json({
            platform: "instagram",
            type: type,
            downloadUrl: mediaUrl,
            title: items.edge_media_to_caption?.edges?.[0]?.node?.text || "Instagram Media"
        });

    } catch (error) {
        return res.status(500).json({ 
            error: "Failed to process Instagram link", 
            details: error.message,
            tip: "Instagram rapidly blocks server IPs. For stable production, routing requests through a residential proxy is highly recommended."
        });
    }
});

/**
 * 🎵 TIKTOK DOWNLOADER ENDPOINT
 */
app.post('/api/download/tiktok', async (req, res) => {
    const { url } = req.body;
    if (!url) return res.status(400).json({ error: "TikTok URL is required" });

    try {
        // Utilizing a stable public open source scraping fallback engine for TikTok parsing
        const tikTokApiUrl = `https://www.tikwm.com/api/?url=${encodeURIComponent(url)}`;
        const response = await axios.get(tikTokApiUrl);

        if (response.data && response.data.code === 0) {
            const data = response.data.data;
            return res.json({
                platform: "tiktok",
                type: "video",
                downloadUrl: data.play, // Direct link without watermark
                watermarkDownloadUrl: data.wmplay, // Link with watermark
                title: data.title,
                author: data.author.nickname
            });
        } else {
            return res.status(400).json({ error: "Failed to extract TikTok media parameters" });
        }
    } catch (error) {
        return res.status(500).json({ error: "TikTok server error occurred", details: error.message });
    }
});

/**
 * 📺 YOUTUBE DOWNLOADER ENDPOINT
 */
app.post('/api/download/youtube', async (req, res) => {
    const { url } = req.body;
    if (!url) return res.status(400).json({ error: "YouTube URL is required" });

    try {
        // Fallback architecture utilizing a robust processing microservice parser
        // In full scale production, developers deploy a standalone instance of 'yt-dlp' inside their cloud app.
        const youtubeParserUrl = `https://api.cobalt.tools/api/json`;
        const response = await axios.post(youtubeParserUrl, {
            url: url,
            vQuality: "720",
            isAudioOnly: false
        }, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (response.data && response.data.url) {
            return res.json({
                platform: "youtube",
                type: response.data.pickerType || "video",
                downloadUrl: response.data.url,
                title: response.data.filename || "YouTube Video"
            });
        } else {
            return res.status(400).json({ error: "Could not fetch YouTube streams for this link" });
        }
    } catch (error) {
        return res.status(500).json({ error: "YouTube parsing architecture exception", details: error.message });
    }
});

// Start listening
app.listen(PORT, () => {
    console.log(`Downloader server successfully initialized on port ${PORT}`);
});
