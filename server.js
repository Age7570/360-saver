app.get('/api/download/instagram', async (req, res) => {
    try {
        const videoUrl = req.query.url;
        // Utilizing a public API wrapper optimized for social scraping
        const response = await axios.get(`https://vreden.web.id{encodeURIComponent(videoUrl)}`);
        
        if (response.data && response.data.status === 200) {
            return res.json({
                success: true,
                title: 'Instagram Media',
                downloadUrl: response.data.result[0].url, // Extracts the high-definition video/image CDN URL
                thumbnail: response.data.result[0].thumbnail || ''
            });
        }
        throw new Error("Unable to parse Instagram link");
    } catch (error) {
        res.status(500).json({ success: false, error: "Failed to process video. The link might be private or broken." });
    }
});

app.get('/api/download/tiktok', async (req, res) => {
    try {
        const videoUrl = req.query.url;
        const response = await axios.get(`https://vreden.web.id{encodeURIComponent(videoUrl)}`);
        
        if (response.data && response.data.status === 200) {
            return res.json({
                success: true,
                title: response.data.result.title || 'TikTok Video',
                downloadUrl: response.data.result.video, // Premium watermark-free stream
                thumbnail: response.data.result.cover
            });
        }
        throw new Error("Unable to parse TikTok link");
    } catch (error) {
        res.status(500).json({ success: false, error: "Failed to extract TikTok media." });
    }
});

app.get('/api/download/youtube', async (req, res) => {
    try {
        const videoUrl = req.query.url;
        const response = await axios.get(`https://vreden.web.id{encodeURIComponent(videoUrl)}`);
        
        if (response.data && response.data.status === 200) {
            return res.json({
                success: true,
                title: response.data.result.title || 'YouTube Video',
                downloadUrl: response.data.result.download, 
                thumbnail: response.data.result.metadata.thumbnail
            });
        }
        throw new Error("Unable to parse YouTube link");
    } catch (error) {
        res.status(500).json({ success: false, error: "YouTube downloading is heavily throttled on cloud servers." });
    }
});
