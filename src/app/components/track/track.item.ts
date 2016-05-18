
namespace app.components {
  export interface ITrack {
    title: string;
    artist: string;
    prevLyrics: string;
    soundCloudId?: string;
    duration?: number;
    albumThumbnail?: string;
    soundCloudPermalink?: string;
  }
}
